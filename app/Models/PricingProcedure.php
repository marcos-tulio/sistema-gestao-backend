<?php

namespace App\Models;

class PricingProcedure extends Pricing {

    protected $table = 'pricing_procedures';

    /*protected $fillable = [
        "price",
        "commission",
        "taxes",
        "cardTax",
        "includesFixedExpenses",
        "includesFixedExpensesPercentual",
        "isCurrent",
        "includesDirectLabor",
        "timeSpentInMinutes",
    ];*/

    public function procedure() {
        return $this->hasOne(Procedure::class, 'id', 'procedure_id');
    }
}
