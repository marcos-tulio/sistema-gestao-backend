<?php

namespace App\Providers;

use App\Models\FinancialCategory;
use App\Models\FinancialItem;
use App\Models\FinancialItemValue;
use App\Observers\FinancialCategoryObserver;
use App\Observers\FinancialItemObserver;
use App\Observers\FinancialItemValueObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    public function register(): void {
        //
    }

    public function boot(): void {
        FinancialItemValue::observe(FinancialItemValueObserver::class);
        FinancialItem::observe(FinancialItemObserver::class);
        FinancialCategory::observe(FinancialCategoryObserver::class);
    }
}
