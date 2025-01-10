<?php

namespace App\Http\Controllers;

use App\Http\Traits\CartTrait;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use CartTrait;

    public function __construct()
    {
        $this->initializeCartSession();
    }

    public function store(Product $product)
    {
        $this->addToCart($product);
    }

    public function destroy(Product $product)
    {
        $this->removefromCart($product);
    }
}
