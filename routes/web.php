<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
Route::middleware('auth')->group( function () {
    Route::resource('categories', CategoryController::class);

    Route::get('/categories/{category}/products',[CategoryController::class, 'getProducts'])->name('categories.products');

    Route::get('/search/{searchKey}', [ProductController::class, 'searchProduct'])->name('search');

    Route::resource('products', ProductController::class);

    Route::get('/cart',[CartController::class,'index'])->name('cart.index');
    Route::post('/cart/add/',[CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{product}/update',[CartController::class,'update'])->name('cart.update');
    Route::get('/cart/destroy/{product}',[CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/address', [AddressController::class,'store'])->name('address.store');
});

Route::get('dumpSession', function(){
    dd(session()->get('cart'));
});
Route::get('clearSession', function(){
    return session()->flush('cart');
});
