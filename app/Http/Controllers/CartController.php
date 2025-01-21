<?php

namespace App\Http\Controllers;

use App\Http\Traits\CartTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\calculateSubTotalController;

class CartController extends Controller
{
    use CartTrait;

    public function __construct()
    {
        $this->initializeCartSession();
    }

    public function getAll()
    {
        return $this->getCartItems();
    }


    public function index(calculateSubTotalController $subtotalCalculator, GetRecommendedProductsController $recommendedProducts)
    {
        return Inertia::render('Cart/IndexCart',[
            'products' => (array) $this->getCartItems(), // vem da trait.
            'subtotal' => number_format($subtotalCalculator->calculate(), 2, '.', ''),
            'recommended_products' => (array) $recommendedProducts->handle(),
            'is_admin' => auth()->user()->isAdmin(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $product = Product::findOrFail($validated['product_id']);
        if (!$product) {
            return back()->with([
                'message' => 'Product not found',
                'error' => true,
            ]);
        }
        $product->quantity = $validated['quantity'];

        $this->addToCart($product);
        return back()->with([
            'message' => 'Product successfully added to cart!',
            'success' => true,
        ]);;
    }

    public function update(Product $product, Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        //verifica se o item está no carrinho
        if(! $this->isInCart($product) ){
            return back()->with('error','The product is not in the cart.');
        }

        $this->updateQuantity($product,$validated['quantity']);
        return back()->with('success', 'Quantity successfully updated.');
    }

    public function destroy(Product $product)
    {
        $this->removefromCart($product);
    }
}
