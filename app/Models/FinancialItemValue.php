<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialItemValue extends Model {
    public $timestamps = false;

    public function financialItem() {
        return $this->belongsTo(FinancialItem::class);
    }
}
