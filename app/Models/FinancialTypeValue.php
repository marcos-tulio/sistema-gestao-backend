<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTypeValue extends Model {
    public $timestamps = false;

    protected $fillable = [
        "financial_type_id",
        'year',
        'month',
        'value',
    ];

    public function type() {
        return $this->belongsTo(FinancialType::class, 'financial_type_id');
    }
}
