<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialType extends Model {
    public $timestamps = false;

    public function values() {
        return $this->hasMany(FinancialTypeValue::class);
    }

    public function categories() {
        return $this->hasMany(FinancialCategory::class);
    }
}
