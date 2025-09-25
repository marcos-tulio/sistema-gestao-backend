<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PricingProductRecordResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        $currentPricing = $this->currentPricing ?? [];
        $latestPricing  = $this->latestPricing ?? [];

        if ($currentPricing && $latestPricing && $currentPricing->id == $latestPricing->id)
            $latestPricing = [];

        $data = parent::toArray($request);

        $fields = [
            'price',
            'commission',
            'taxes',
            'cardTax',
            'variableExpenses',
            'fixedExpenses',
            'totalExpenses',
            'contributionMargin',
            'profitability',
            'includesFixedExpenses',
            'includesFixedExpensesPercentual',
        ];

        $data['current'] = collect($fields)->mapWithKeys(fn($field) => [
            $field => $currentPricing[$field] ?? null,
        ])->toArray();

        $data['new'] = collect($fields)->mapWithKeys(fn($field) => [
            $field => $latestPricing[$field] ?? null,
        ])->toArray();

        $data['financialSummary'] = [
            'revenue' => [
                'total' => 0,
                'average' => 114264.63
            ],
            'variableExpenses' => [
                'total' => 1331175.59,
                'average' => 133117.56
            ],
            'fixedExpenses' => [
                'total' => 0,
                'average' => 70482.90
            ],
            'othersExpenses' => [
                'total' => 1331175.59,
                'average' => 133117.56
            ],
            'directLaborPayments' => [
                'total' => 45000,
                'average' => 2000,
                'comment' => 'Custo com pagamentos dos funcionários com MOD'
            ],
            'directLaborMinutes' => [
                'total' => 15000,
                'average' => 10000,
                'comment' => 'Tempo de trabalho dos funcionários com MOD'
            ],
            'directLaborExpenses' => [
                'total' => 3.35,
                'average' => 2.15,
                'comment' => 'directLaborPayments / directLaborMinutes'
            ],
            'fixedExpensesByDirectLaborMinutes' => [
                'total'   => 3.17,
                'average' => 3.17,
                'comment' => 'fixedExpenses / directLaborMinutes.total'
            ],
            'fixedExpensesByRevenue' => [
                'total'   => 0,
                'average' => 0.61683918,
                'comment' => 'fixedExpenses / directLaborMinutes'
            ]
        ];

        unset(
            $data['current_pricing'],
            $data['latest_pricing'],
        );

        return $data;
    }
}
