<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 * 
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        return [
                'subtotal' => $this->faker->randomFloat(2, 10, 500), // Valor entre 10 e 500
                'status' => $this->faker->randomElement(['pending_payment','transporting', 'completed', 'canceled']),
                'user_id' => $user,
        ];
    }
}
