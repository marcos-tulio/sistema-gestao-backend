<?php

namespace App\Observers;

use App\Models\FinancialItemValue;
use Illuminate\Support\Facades\DB;

class FinancialItemValueObserver extends FinancialObserver {

    public function saved(FinancialItemValue $value): void {
        $this->recalculateTotalByItemValue($value);
    }

    public function deleted(FinancialItemValue $value): void {
        $this->recalculateTotalByItemValue($value);
    }

    public function recalculateTotalByItemValue(FinancialItemValue $value): void {
        $this->recalculateTotalByType(
            $value->item?->category?->type,
            $value->year,
            $value->month
        );
    }
}
