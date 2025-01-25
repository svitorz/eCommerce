<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Database\Factories\OrdersProductsFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Vitor Souza',
            'email' => 'vitor@example.com',
            'password' => Hash::make('12345678'),
            'isAdmin' => false,
        ]);
        User::factory()->create([
            'name' => 'Teste User no admin',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
            'isAdmin' => false,
        ]);
        $this->call([CategorySeeder::class, ProductSeeder::class]);
        Order::factory(10)->create()->each(function ($order) {
            OrdersProductsFactory::new()->count(3)->create(['order_id' => $order->id]);

            \App\Models\Payment::factory()->create([
                'order_id' => $order->id,
            ]);
        });

        Address::factory()->create([
            'country' => 'Brasil',
            'state' => 'São Paulo',
            'city' => 'Rio Preto',
            'street' => 'Rua Exemplo',
            'zip_code' => '12335-000',
            'number' => 123,
            'user_id' => $user
        ]);
    }
}
