<?php

namespace App\Observers;

use App\Models\FinancialType;
use Illuminate\Support\Facades\DB;

class FinancialObserver {

    public function recalculateTotalByType(FinancialType $type, $year, $month): void {
        if (!$type) return;

        $query = DB::table('financial_item_values as v')
            ->join('financial_items as i', 'i.id', '=', 'v.financial_item_id')
            ->join('financial_categories as c', 'c.id', '=', 'i.financial_category_id')
            ->where('c.financial_type_id', $type->id)
            ->where('v.year', $year)
            ->where('v.month', $month);

        // Soma todos os valores dos itens do mesmo tipo, ano e mês
        $items = $query->select('v.value')->get();
        $total = $items->sum('value');

        // Total diferente de zero → cria ou atualiza ou Existem registros → mantém o total zero
        if ($total !== 0 || $items->isNotEmpty()) {
            $type->values()->updateOrCreate(['year' => $year, 'month' => $month], ['value' => $total]);
            return;
        }

        // Nenhum registro → apaga o total
        $type->values()
            ->where('year', $year)
            ->where('month', $month)
            ->delete();
    }
}
