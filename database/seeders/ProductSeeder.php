<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {

    public function run(): void {
        Product::create([
            'name' => 'Shampoo',
            'purchasePrice' => 56.00,
            'quantity' => 120,
            'unit' => 'mL'
        ]);

        Product::create([
            'name' => 'Condicionador',
            'purchasePrice' => 45.50,
            'quantity' => 120,
            'unit' => 'mL'
        ]);

        Product::create([
            'name' => 'Máscara capilar',
            'purchasePrice' => 60.00,
            'quantity' => 80,
            'unit' => 'g'
        ]);

        Product::create([
            'name' => 'Óleo capilar',
            'purchasePrice' => 42.00,
            'quantity' => 30,
            'unit' => 'mL'
        ]);

        Product::create([
            'name' => 'Escova de LED',
            'purchasePrice' => 50.83,
            'quantity' => 1,
            'unit' => 'un.'
        ]);

        Product::create([
            'name' => 'Escova massageadora',
            'purchasePrice' => 2.60,
            'quantity' => 1,
            'unit' => 'un.'
        ]);
    }
}
