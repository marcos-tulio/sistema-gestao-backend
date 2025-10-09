<?php

namespace Database\Seeders;

use App\Models\FinancialType;
use Illuminate\Database\Seeder;

class FinancialCategorySeeder extends Seeder {

    public function run(): void {
        FinancialType::find(1)?->categories()->createMany([
            ['title' => 'Receitas', 'isDeletable' => false],
        ]);

        FinancialType::find(2)?->categories()->createMany([
            ['title' => 'Gastos Diretos', 'isDeletable' => false],
        ]);
    }
}
