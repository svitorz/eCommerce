<?php

namespace App\Http\Controllers;

use App\Http\Traits\CartTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    use CartTrait;

    public function __construct()
    {
        $this->initializeCartSession();
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

    public function destroy(Product $product)
    {
        $this->removefromCart($product);
    }
}
