<?php

namespace App\Observers;

use App\Models\FinancialItem;

class FinancialItemObserver {

    public function deleted(FinancialItem $item): void {
        foreach ($item->values as $value) {
            // Dispara o mesmo recálculo do FinancialItemValueObserver
            $observer = new FinancialItemValueObserver();
            $observer->recalculateTypeTotal($value);
        }
    }
}
