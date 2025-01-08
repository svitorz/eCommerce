<?php

namespace App\Http\Controllers;

use App\Http\Middleware\isUserAdmin;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller implements HasMiddleware
{
    public Product $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }
    /**
     * @return array
     * Insert middleware at this functions.
     */
    public static function middleware() : array
    {
        // impede que usuários comuns façam alterações nos produtos.
        return [
            new Middleware(isUserAdmin::class, except:['show','index'])
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia('Products/IndexProducts',[
            'products' => $this->product->with('category')->get(),
            'isAdmin' => request()->user()->isAdmin()
        ]);
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
    public function store(StoreProductRequest $request)
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
