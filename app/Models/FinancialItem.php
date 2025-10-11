<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FinancialItem extends Model {
    public $timestamps = false;

    protected $fillable = [
        "financial_category_id",
        "title",
        "isEditable"
    ];

    protected static function booted() {
        static::saving(function ($model) {
            $model->name = Str::slug($model->title);
        });
    }

    public function values() {
        return $this->hasMany(FinancialItemValue::class);
    }

    public function category() {
        return $this->belongsTo(FinancialCategory::class);
    }
}
