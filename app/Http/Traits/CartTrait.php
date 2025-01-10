<?php 

namespace App\Http\Traits;

use App\Models\Product;

trait CartTrait {

    /**
     * Adiciona um item ao carrinho do usuário.
     */
    public function addToCart(Product $product):void
    {
        request()->session()->push('products',$product);
    }
    
    /**
     * Remove um produto do carrinho.
     */
    public function removefromCart(Product $product):void
    {
        request()->session()->pull('products',$product);
    }


    /**
     * Retorna todos os produtos do carrinho.
     */
    public function getCartItems(): array 
    {
        return request()->session()->only(['products']);
    }

    /**
     * Check if a product is in cart
     */
    public function isInCart($productId)
    {
        $cart = session()->get('cart', []);
        return isset($cart[$productId]);
    }
}