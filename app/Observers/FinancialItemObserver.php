<?php

namespace App\Observers;

use App\Models\FinancialItem;

class FinancialItemObserver extends FinancialObserver {

    public function deleted(FinancialItem $item): void {
        foreach ($item->values as $value) {
            $observer = new FinancialItemValueObserver();
            $observer->recalculateTotalByItemValue($value);
        }
    }
}
