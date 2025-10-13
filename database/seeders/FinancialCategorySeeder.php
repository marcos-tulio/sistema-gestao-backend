<?php

namespace Database\Seeders;

use App\Models\FinancialType;
use Illuminate\Database\Seeder;

class FinancialCategorySeeder extends Seeder {

    public function run(): void {
        FinancialType::find(1)?->categories()->createMany([
            [
                'title' => 'Receitas',
                'isDeletable' => false,
                'isEditable'  => false
            ],
        ]);

        FinancialType::find(2)?->categories()->createMany([
            [
                'title' => 'Gastos Diretos',
                'isDeletable' => false,
                'isEditable'  => false
            ],
        ]);

        FinancialType::find(3)?->categories()->createMany([
            [
                'title' => 'Despesas Financeiras',
                'isDeletable' => false,
                'isEditable'  => true
            ],
            [
                'title' => 'Despesas Administrativas',
                'isDeletable' => false,
                'isEditable'  => true
            ],
            [
                'title' => 'Despesas com Pessoas',
                'isDeletable' => false,
                'isEditable'  => false
            ],
            [
                'title' => 'Despesas com Terceiros',
                'isDeletable' => true,
                'isEditable'  => true
            ],
            [
                'title' => 'Despesas com Limpeza e outros',
                'isDeletable' => true,
                'isEditable'  => true
            ],
            [
                'title' => 'Outras despesas',
                'isDeletable' => true,
                'isEditable'  => true
            ],
        ]);

        FinancialType::find(4)?->categories()->createMany([
            [
                'title' => 'Investimentos em Marketing',
                'isDeletable' => false,
                'isEditable'  => false
            ],
            [
                'title' => 'Seguro Patrimônial',
                'isDeletable' => false,
                'isEditable'  => false
            ],
        ]);
    }
}
