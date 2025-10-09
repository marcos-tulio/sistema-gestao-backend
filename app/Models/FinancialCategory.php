<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialCategory extends Model {
    public $timestamps = false;

    public function items() {
        return $this->hasMany(FinancialItem::class);
    }
}
