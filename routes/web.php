<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Route::get('/users', function () {
//     return view('users/index');
// });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->controller(CustomerController::class)->group(function () {
    
    // 1. READ ALL (Index)
    Route::get('/customers', 'index')->name('customers.index');
    
    // 2. CREATE (Show Form)
    Route::get('/customers/create', 'create')->name('customers.create');
    
    // 3. CREATE (Store Data)
    Route::post('/customers', 'store')->name('customers.store');
    
    // 4. READ ONE (Show Detail)
    Route::get('/customers/{customer}', 'show')->name('customers.show'); 
    
    // 5. UPDATE (Show Edit Form)
    Route::get('/customers/{customer}/edit', 'edit')->name('customers.edit');
    
    // 6. UPDATE (Update Data)
    Route::match(['put', 'patch'], '/customers/{customer}', 'update')->name('customers.update');

    // 7. DELETE (Destroy)
    Route::delete('/customers/{customer}', 'destroy')->name('customers.destroy');
    
});

Route::middleware(['auth'])->group(function () {

    Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])
        ->name('products');

    Route::post('/products/{id}', [App\Http\Controllers\ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/purchase', [App\Http\Controllers\ProductController::class, 'purchase'])
        ->name('products.purchase');

    Route::get('/commissions/{sale_id}', [App\Http\Controllers\ProductController::class, 'commissions'])
        ->name('products.commissions');

    Route::get('/sales', [App\Http\Controllers\ProductController::class, 'sales'])
        ->name('sales');

});
