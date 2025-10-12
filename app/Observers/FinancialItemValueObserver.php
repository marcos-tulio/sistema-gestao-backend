<?php

namespace App\Observers;

use App\Models\FinancialItemValue;
use Illuminate\Support\Facades\DB;

class FinancialItemValueObserver {

    public function saved(FinancialItemValue $value): void {
        $this->recalculateTypeTotal($value);
    }

    public function deleted(FinancialItemValue $value): void {
        $this->recalculateTypeTotal($value);
    }

    public function recalculateTypeTotal(FinancialItemValue $value): void {

        $item = $value->item;
        $category = $item?->category;
        $type = $category?->type;

        if (!$type) return;

        $year = $value->year;
        $month = $value->month;

        // Soma todos os valores dos itens do mesmo tipo, ano e mês
        $total = DB::table('financial_item_values as v')
            ->join('financial_items as i', 'i.id', '=', 'v.financial_item_id')
            ->join('financial_categories as c', 'c.id', '=', 'i.financial_category_id')
            ->where('c.financial_type_id', $type->id)
            ->where('v.year', $year)
            ->where('v.month', $month)
            ->sum('v.value');

        if ($total !== 0) {
            // Total diferente de zero → cria ou atualiza
            $type->values()->updateOrCreate(
                ['year' => $year, 'month' => $month],
                ['value' => $total]
            );
        } else {
            // Total é zero → verifica se existem registros de FinancialItemValue
            $exists = DB::table('financial_item_values as v')
                ->join('financial_items as i', 'i.id', '=', 'v.financial_item_id')
                ->join('financial_categories as c', 'c.id', '=', 'i.financial_category_id')
                ->where('c.financial_type_id', $type->id)
                ->where('v.year', $year)
                ->where('v.month', $month)
                ->exists();

            if (!$exists) {
                // Nenhum registro → apaga o total
                $type->values()
                    ->where('year', $year)
                    ->where('month', $month)
                    ->delete();
            } else {
                // Existem registros → mantém o total zero
                $type->values()->updateOrCreate(
                    ['year' => $year, 'month' => $month],
                    ['value' => $total]
                );
            }
        }
    }
}
