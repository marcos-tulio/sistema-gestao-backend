<?php

namespace Database\Seeders;

use App\Models\FinancialType;
use Illuminate\Database\Seeder;

class FinancialTypeValueSeeder extends Seeder {

    public function run(): void {
        // Faturamento
        FinancialType::find(1)?->values()->createMany([
            ['year' => 2025, 'month' => 1,  'value' => 83297.68],
            ['year' => 2025, 'month' => 2,  'value' => 32347.96],
            ['year' => 2025, 'month' => 3,  'value' => 45529.95],
            ['year' => 2025, 'month' => 4,  'value' => 100000.00],
            ['year' => 2025, 'month' => 5,  'value' => 120000.00],
            ['year' => 2025, 'month' => 6,  'value' => 120000.00],
            ['year' => 2025, 'month' => 7,  'value' => 120000.00],
            ['year' => 2025, 'month' => 8,  'value' => 150000.00],
            ['year' => 2025, 'month' => 9,  'value' => 150000.00],
            ['year' => 2025, 'month' => 10, 'value' => 150000.00],
            ['year' => 2025, 'month' => 11, 'value' => 150000.00],
            ['year' => 2025, 'month' => 12, 'value' => 150000.00],
        ]);

        // Custos e despesas variáveis
        FinancialType::find(2)?->values()->createMany([
            ['year' => 2025, 'month' => 1,  'value' => 25324.66],
            ['year' => 2025, 'month' => 2,  'value' => 11988.51],
            ['year' => 2025, 'month' => 3,  'value' =>  8948.55],
            ['year' => 2025, 'month' => 4,  'value' => 29064.94],
            ['year' => 2025, 'month' => 5,  'value' => 22483.49],
            ['year' => 2025, 'month' => 6,  'value' => 26160.00],
            ['year' => 2025, 'month' => 7,  'value' => 26160.00],
            ['year' => 2025, 'month' => 8,  'value' => 31200.00],
            ['year' => 2025, 'month' => 9,  'value' => 31200.00],
            ['year' => 2025, 'month' => 10, 'value' => 31200.00],
            ['year' => 2025, 'month' => 11, 'value' => 31200.00],
            ['year' => 2025, 'month' => 12, 'value' => 31200.00],
        ]);

        // Despesas Fixas
        FinancialType::find(3)?->values()->createMany([
            ['year' => 2025, 'month' => 1,  'value' => 42640.19],
            ['year' => 2025, 'month' => 2,  'value' => 36085.75],
            ['year' => 2025, 'month' => 3,  'value' => 64784.76],
            ['year' => 2025, 'month' => 4,  'value' => 35516.02],
            ['year' => 2025, 'month' => 5,  'value' => 35848.46],
            ['year' => 2025, 'month' => 6,  'value' => 40591.31],
            ['year' => 2025, 'month' => 7,  'value' => 47431.22],
            ['year' => 2025, 'month' => 8,  'value' => 45761.55],
            ['year' => 2025, 'month' => 9,  'value' => 75262.55],
            ['year' => 2025, 'month' => 10, 'value' => 75263.55],
            ['year' => 2025, 'month' => 11, 'value' => 75264.55],
            ['year' => 2025, 'month' => 12, 'value' => 79013.37],
        ]);

        // Investimentos
        FinancialType::find(4)?->values()->createMany([
            ['year' => 2025, 'month' => 1,  'value' => 15666.60],
            ['year' => 2025, 'month' => 2,  'value' => 13108.21],
            ['year' => 2025, 'month' => 3,  'value' => 17715.76],
            ['year' => 2025, 'month' => 4,  'value' => 13249.00],
            ['year' => 2025, 'month' => 5,  'value' => 15949.00],
            ['year' => 2025, 'month' => 6,  'value' => 15949.00],
            ['year' => 2025, 'month' => 7,  'value' => 15949.00],
            ['year' => 2025, 'month' => 8,  'value' => 15949.00],
            ['year' => 2025, 'month' => 9,  'value' => 17949.00],
            ['year' => 2025, 'month' => 10, 'value' => 17949.00],
            ['year' => 2025, 'month' => 11, 'value' => 17949.00],
            ['year' => 2025, 'month' => 12, 'value' => 14949.00],
        ]);
    }
}
