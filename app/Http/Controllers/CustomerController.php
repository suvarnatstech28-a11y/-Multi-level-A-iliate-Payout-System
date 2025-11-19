<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // READ (All)
    public function index()
    {
        // $customers = Customer::all();
        $customers = Customer::with('parent')->get();
        // dd($customers);
        $parents   = [];
        return view('customers.index', compact('customers','parents'));
    }

    public function create()
    {
        $parents = Customer::all();
        return view('customers.add', compact('parents'));
    }

    // CREATE (Action)
    public function store(Request $request)
    {
        // 1. Validate the request data (Omitted for brevity)
        // 2. Create the record
        //dd( $request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email|max:100',
            'phone' => 'nullable|string|max:10',
            'parent_id' => 'string',
        ]);

        // 2. Database Action (Only runs if validation passes)
        try {
            
            $customer_data = Customer::create($validatedData);
            
            $user = User::create([
                'customer_id'  => $customer_data->id,
                'name'         => $validatedData['name'],
                'email'        => $validatedData['email'],
                'password'     => Hash::make($validatedData['email']), // <-- Hash the password!
                'added_from'   => 'customer', // <-- Set added_from
                // Add any other required user fields (e.g., 'role_id')
            ]);
            // 3. Success Redirection with Flash Message
            return redirect()->route('customers.index')->with('success', 'Customer **' . $validatedData['name'] . '** has been successfully created.');

        } catch (\Exception $e) {
            
            // 4. Failure Redirection with Flash Message
            // Handle any database or other unexpected errors
            return redirect()->route('customers.index')->with('error', 'An error occurred while saving the customer: ' . $e->getMessage());
        }
    
    }

    // READ (One)
    public function edit(Customer $customer)
    {
        $parents = User::where('id', '!=', $customer->id)->get();
        return view('customers.edit', compact('customer','parents'));
    }

    // UPDATE (Action)
    public function update(Request $request, Customer $customer)
    {
        $newEmail = $request->input('email');
        $exists = DB::table('customers')
                    ->where('email', $newEmail)
                    ->where('id', '!=', $customer->id)
                    ->exists(); // Returns true if a match is found, false otherwise
        if ($exists) {
            // 3. If a duplicate is found, redirect back with an error message
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'The email address is already taken by another customer.');
        }else{
            User::where('customer_id',$customer->id)->update(['name'=>$request->name,'email'=> $request->email]);
            $customer->update($request->all());
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
        }
    }

    // DELETE (Action)
    public function destroy(Customer $customer)
    {
        $customer->delete();
        //User::where('customer_id' , $customer->id)->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }

}
