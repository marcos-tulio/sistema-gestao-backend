<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Pricing extends Model {

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
        "includesFixedExpensesPercentual",
        "isCurrent"
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

    protected static function booted() {
        static::saving(function ($model) {
            // Despesas variáveis
            $model->variableExpenses = $model->calculateVariableExpenses();

            // Despesas fixas
            $model->fixedExpenses = $model->calculateFixedExpenses();

            // Total das despesas
            $model->totalExpenses = bcadd(
                $model->variableExpenses ?? 0,
                $model->fixedExpenses ?? 0,
                8
            );

            // Margem de contribuição
            $model->contributionMargin = bcsub(
                $model->price ?? 0,
                $model->variableExpenses ?? 0,
                8
            );

            // Lucratividade
            $model->profitability = bcsub(
                $model->price ?? 0,
                $model->totalExpenses ?? 0,
                8
            );
        });
    }

    protected function calculateFixedExpenses(): string {
        if (!$this->includesFixedExpenses)
            return "0";

        // fazer o calculo com o resumo financeiro
        if ($this->includesFixedExpensesPercentual)
            return bcadd(10, 0, 8);

        return bcadd(10, 0, 8);

        /*

        // Despesas Fixas
        const fixedExpensesPercentageComputed = computed(() =>{
            if ( !data.value.includesFixedExpenses )
                return 0

            // Cálculo por Percentual
            if ( data.value.includesFixedExpensesPercentual )
                return Decimal(props.financial.fixedExpensesByRevenue.average).mul(100).toNumber()

            // Cálculo por Hora
            const valueCurrency = 
                    Decimal(props.financial.fixedExpensesByDirectLaborMinutes.average)
                    .mul(data.value.timeSpent ?? 0)

            // Cálculo por Hora em porcentagem
            return valueCurrency.div(data.value.price || 1).mul(100).toNumber()
        })
        
        */
    }

    protected function calculateVariableExpenses(): string {
        // custo
        $cost = $this->purchasePrice ?? 0;
        $cost = bcadd($cost, $this->materialsCost ?? 0, 8);

        // taxas
        $percentual = bcadd($this->commission ?? 0, $this->cardTax ?? 0, 8);
        $percentual = bcadd($percentual, $this->taxes ?? 0, 8);
        $percentual = bcdiv($percentual, 100, 8);

        // Todo: incluir MOD no filho


        // Total
        $total = bcmul($this->price ?? 0, $percentual, 8);
        $total = bcadd($total, $cost, 8);

        return $total;
    }
}
