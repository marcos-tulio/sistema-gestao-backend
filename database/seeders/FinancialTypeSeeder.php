<?php

namespace Database\Seeders;

use App\Models\FinancialType;
use Illuminate\Database\Seeder;

class FinancialTypeSeeder extends Seeder {

    public function run(): void {
        FinancialType::create([
            'name'        => 'revenue',
            'title'       => 'Faturamento',
            'isIncome'    => true,
            'isDeletable' => false
        ]);

        FinancialType::create([
            'name'        => 'variableExpenses',
            'title'       => 'Despesas Diretas',
            'isIncome'    => false,
            'isDeletable' => false
        ]);

        FinancialType::create([
            'name'        => 'fixedExpenses',
            'title'       => 'Despesas Indiretas (Fixas)',
            'isIncome'    => false,
            'isDeletable' => false
        ]);

        FinancialType::create([
            'name'        => 'othersExpenses',
            'title'       => 'Investimentos',
            'isIncome'    => false,
            'isDeletable' => false
        ]);
    }
}
