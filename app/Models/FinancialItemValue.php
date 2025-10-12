<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialItemValue extends Model {

    public $timestamps = false;

    protected $fillable = [
        "financial_item_id",
        'year',
        'month',
        'value',
    ];

    public function item() {
        return $this->belongsTo(FinancialItem::class, 'financial_item_id');
    }
}
