<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model {

    public $timestamps = false;

    protected $fillable = [
        "price",
        "commission",
        "taxes",
        "cardTax",
        "variableExpenses",
        "fixedExpenses",
        "totalExpenses",
        "contributionMargin",
        "profitability",
        "includesFixedExpenses",
        "fixedExpensesPercentual",
    ];

    /*
        "timeSpent": 60,
        "includesDirectLabor": true,
        "includesFixedExpenses": false,
        "fixedExpensesPercentual": false,
        "directLaborExpanses": 0,
    */

    protected $casts = [
        'price' => 'decimal:4',
        'commission' => 'decimal:4',
        'taxes' => 'decimal:4',
        'cardTax' => 'decimal:4',

        'variableExpenses'   => 'decimal:8',
        'fixedExpenses'      => 'decimal:8',
        'totalExpenses'      => 'decimal:8',
        'contributionMargin' => 'decimal:8',
        'profitability'      => 'decimal:8',
    ];

    public function getProfitabilityPercentualAttribute() {

        if ($this->price == 0 || $this->price === null) return null;

        return bcdiv($this->profitability, $this->price, 4);
    }
}
