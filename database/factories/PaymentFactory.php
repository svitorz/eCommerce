<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => \App\Models\Order::inRandomOrder()->first()->id,
            'full_name' => $this->faker->name(),
            'ccv' => $this->faker->numberBetween(100, 999), // Gera um código de segurança de 3 dígitos
            'card_number' => $this->faker->creditCardNumber(), // Gera um número fictício de cartão
            'card_expiration' => \Carbon\Carbon::createFromFormat('m/Y', $this->faker->creditCardExpirationDateString)->startOfMonth()->format('Y-m-d'), // Formata como 'YYYY-MM-DD'
        ];
    }
}
