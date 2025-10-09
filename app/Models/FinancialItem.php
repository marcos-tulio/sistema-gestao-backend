<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FinancialItem extends Model {
    public $timestamps = false;

    protected static function booted() {
        static::saving(function ($model) {
            $model->name = Str::slug($model->title);
        });
    }

    public function values() {
        return $this->hasMany(FinancialItemValue::class);
    }
}
