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

    public function index()
    {
        return Inertia::render('Cart/IndexCart',[
            'products' => (array) $this->getCartItems(), // vem da trait.
            'subtotal' => number_format($this->calculateSubTotal(), 2, '.', ''),
            'recommended_products' => (array) $this->getRecommendedProducts(),
            'is_admin' => auth()->user()->isAdmin(),
        ]);
    }

    /**
     * Retorna o valor total dos itens do carrinho do usuário.
     */
    public function calculateSubTotal(): float
    {
        $cartProducts = $this->getCartItems();

        $subtotal = 0;

        foreach ($cartProducts as $product) {
            $subtotal += $product['quantity'] * $product['price'];
        }

        return $subtotal;
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

    /**
     * Retorna produtos com base nas escolhas do usuário.
     */
    public function getRecommendedProducts(int $limit = 3)
    {
        // Obtenha os produtos no carrinho
        $cartItems = $this->getCartItems();

        if(empty($cartItems)){
            return Product::distinct()->with('category')->limit($limit)->get();
        }

        // Inicializa um array para armazenar as categorias dos produtos no carrinho
        $categories = [];

        // Preenche o array com as categorias dos produtos no carrinho
        foreach ($cartItems as $item) {
            $categories[] = $item['category_id']; // Assumindo que o produto tem o campo 'category_id'
        }

        // Remover duplicatas para evitar que busquemos produtos de categorias repetidas
        $categories = array_unique($categories);

        // Buscar produtos recomendados
        // Excluindo os produtos que já estão no carrinho e filtrando pelas categorias
        $recommendedProducts = Product::whereIn('category_id', $categories)
            ->whereNotIn('id', array_column($cartItems, 'id')) // Exclui produtos já no carrinho
            ->with('category')
            ->limit($limit) // Limite de 3 produtos, mas pode ser ajustado
            ->get();

        return $recommendedProducts->toArray();
    }
}
