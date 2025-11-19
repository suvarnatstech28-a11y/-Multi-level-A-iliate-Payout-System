<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id)
    {
        // dd(auth()->id());
        $product  = Product::findOrFail($id);
        $user     = User::where('id', auth()->id())->first();
        $customer = Customer::where('id', $user->customer_id)->first();

        $purchase = Sale::create([
            'product_id'  => $product->id,
            'customer_id' => $user->customer_id ?? null,
            'parent_id'   => $customer->parent_id ?? null,
        ]);
        return redirect()->back()->with('success', 'Product purchased successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function purchase(Product $product)
    {
        $user     = User::where('id', auth()->id())->first();
        $purchase = Sale::where('customer_id', $user->customer_id)->get();
        $customer = Customer::where('id', $user->customer_id)->get();
        
        $purchases = Sale::with(['product', 'customer'])
                    ->where('customer_id', $user->customer_id)
                    ->latest()
                    ->get();

        return view('products.purchase', compact('purchases'));
    }

    public function commissions($saleid){
        $levels = [];
        $salesData = Sale::with(['product', 'customer'])
                    ->where('id', $saleid)
                    ->first();
        $currentParent = $salesData->customer->parent_id;
       
        if($currentParent == null){
           return redirect()->back()->with('success', 'no commission details found!');
        }
        $commissionRates = [10, 5, 3, 2, 1]; // level 1 to 5
        // Traverse 5 ancestors
        for ($i = 0; $i < 5; $i++) {
            if (!$currentParent) break;

            $parent = Customer::find($currentParent);
            //e($parent);
            if (!$parent) break;

            $commissionAmount = ($salesData->product->price * $commissionRates[$i]) / 100;

            $levels[] = [
                'level'     => $i + 1,
                'user'      => $parent->name,
                'email'     => $parent->email,
                'user_id'   => $parent->id,
                'rate'      => $commissionRates[$i],
                'amount'    => $commissionAmount
            ];

            // move to next parent
            $currentParent = $parent->parent_id;
        }
        //dd($levels);

        return view('products.commission', compact('salesData', 'levels'));
    }

     public function sales()
    {
        // $user     = User::where('id', auth()->id())->first();
        // $purchase = Sale::where('customer_id', $user->customer_id)->get();
        // $customer = Customer::where('id', $user->customer_id)->get();
        
        $purchases = Sale::with(['product', 'customer'])
                    ->latest()
                    ->get();

        return view('sales.index', compact('purchases'));
    }
}
