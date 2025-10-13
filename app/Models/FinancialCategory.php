<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FinancialCategory extends Model {
    public $timestamps = false;

    protected $fillable = [
        "financial_type_id",
        "title",
        "order"
    ];

    protected $attributes = [
        'isDeletable' => true,
        'isEditable' => true
    ];

    protected static function booted() {
        static::saving(function ($model) {
            $model->name = Str::slug($model->title);
        });
    }

    public function items() {
        return $this->hasMany(FinancialItem::class, 'financial_category_id');
    }

    public function type() {
        return $this->belongsTo(FinancialType::class, 'financial_type_id');
    }
}
