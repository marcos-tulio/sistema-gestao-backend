<?php

namespace App\Observers;

use App\Models\FinancialCategory;

class FinancialCategoryObserver extends FinancialObserver {

    public function deleted(FinancialCategory $category): void {
        $type = $category->type;
        if (!$type) return;

        $periods = $type->values()->select('year', 'month')->get();

        foreach ($periods as $period)
            $this->recalculateTotalByType($type, $period->year, $period->month);
    }
}
