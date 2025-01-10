<?php 

namespace App\Http\Traits;

use App\Models\Product;

trait CartTrait {
    
    /**
     * Inicia o carrinho dentro das sessões.
     */
    public function initializeCartSession()
    {
        session()->setName('cart');
    }

    public function saveCart()
    {
        session()->save();
    }

    /**
     * Adiciona um item ao carrinho do usuário.
     */
    public function addToCart(Product $product):void
    {
        session()->push('cart',$product);
        $this->saveCart();
    }

    /**
     * Remove um item do carrinho.
     */
    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart', []);
        if (($key = array_search($product, $cart)) !== false) {
            unset($cart[$key]);
        }
        session()->put('cart', $cart);
        $this->saveCart();
    }
    
    /**
     * Remove todos os produtos do carrinho.
     */
    public function clearCart():void
    {
        session()->remove('cart');
        $this->saveCart();
    }


    /**
     * Retorna todos os produtos do carrinho.
     */
    public function getCartItems(): array 
    {
        return session()->get('cart');
    }

    /**
     * Check if a product is in cart
     */
    public function isInCart(Product $product): bool
    {
        $cart = session()->get('cart', []);
        $ids = array_column($cart, 'id');
        return in_array($product->id, $ids);
    }
}