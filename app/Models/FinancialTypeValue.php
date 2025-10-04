<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTypeValue extends Model {
    public $timestamps = false;

    public function financialType() {
        return $this->belongsTo(FinancialType::class);
    }
}
