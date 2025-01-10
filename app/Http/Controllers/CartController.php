<?php

namespace App\Http\Controllers;

use App\Http\Traits\CartTrait;
use App\Models\Product;
class CartController extends Controller
{
    use CartTrait;

    public function addToCart(Product $product)
    {
        if(!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produto não encontrado'
            ], 404);
        }
        
        $this->addToCart($product);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Produto adicionado ao carrinho'
        ], 200);
    }
}
