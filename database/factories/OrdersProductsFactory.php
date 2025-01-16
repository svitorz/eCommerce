<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrdersProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first(); // Pega um produto aleatório

        return [
            'order_id' => Order::factory(), // Cria um pedido automaticamente
            'product_id' => $product->id,  // Usa o ID do produto existente
            'quantity' => $this->faker->numberBetween(1, 5), // Quantidade entre 1 e 5
        ];
    }
}
