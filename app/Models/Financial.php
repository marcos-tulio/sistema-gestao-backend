<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @deprecated
 */
class Financial extends Model {

    public $timestamps = false;

    public function categories() {
        return $this->hasMany(FinancialCategory::class);
    }
}
