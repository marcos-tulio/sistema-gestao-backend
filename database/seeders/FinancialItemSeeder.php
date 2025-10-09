<?php

namespace Database\Seeders;

use App\Models\FinancialCategory;
use Illuminate\Database\Seeder;

class FinancialItemSeeder extends Seeder {

    public function run(): void {
        FinancialCategory::find(1)?->items()->createMany([
            ['title' => 'Receitas', 'isDeletable' => false],
        ]);

        FinancialCategory::find(2)?->items()->createMany([
            ['title' => 'Comissão'],
            ['title' => 'Fornecedores'],
            ['title' => 'Taxa de cartão'],
            ['title' => 'Impostos'],
        ]);
    }
}
