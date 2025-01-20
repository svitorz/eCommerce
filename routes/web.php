<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::middleware('auth')->group( function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    // busca específica de categorias.
    Route::get('/categories/{category}/products',[CategoryController::class, 'getProducts'])->name('categories.products');

    //buscas
    Route::get('/search/{searchKey}', [ProductController::class, 'searchProduct'])->name('search');

    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);


    Route::resource('orders', OrderController::class);

    // carrinho
    Route::get('/cart',[CartController::class,'index'])->name('cart.index');
    Route::post('/cart/add/',[CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{product}/update',[CartController::class,'update'])->name('cart.update');
    Route::get('/cart/destroy/{product}',[CartController::class, 'destroy'])->name('cart.destroy');

    // endereço
    Route::post('/address', [AddressController::class,'store'])->name('address.store');

    Route::post('/payment',[PaymentController::class,'store'])->name('payment.store');
});
Route::get('/session', function(){
    dd(request()->session());
});
