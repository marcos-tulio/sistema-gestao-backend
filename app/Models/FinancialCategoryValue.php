<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialCategoryValue extends Model {
    public $timestamps = false;

    public function financialCategory() {
        return $this->belongsTo(FinancialCategory::class);
    }
}
