<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FinancialTypeCollectionResource extends ResourceCollection {
    public static $wrap = null;

    /*public function toArray($request) {
        return [
            "types" => $this->collection->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'title' => $item->title,
                    'isIncome' => $item->isIncome,
                    'categories' => FinancialCategoryResource::collection($item->categories),
                    "total" => [
                        [
                            "year" => 2025,
                            "monthly" => [
                                "jan" => 42640.19,
                                "feb" => 36085.75,
                                "mar" => 64784.76,
                                "apr" => 35516.02,
                                "may" => 35848.46,
                                "jun" => 40591.31,
                                "jul" => 47431.22,
                                "aug" => 45761.55,
                                "sep" => 75262.55,
                                "oct" => 75263.55,
                                "nov" => 75264.55,
                                "dec" => 79013.37
                            ],
                            "annual" => 653463.27,
                            "annualAverage" => 65346.33
                        ]
                    ]
                ];
            }),
            "total" => [
                "incomes" => [
                    [
                        "year" => 2025,
                        "monthly" => [
                            "jan" => 83297.68,
                            "feb" => 32347.96,
                            "mar" => 45529.95,
                            "apr" => 100000,
                            "may" => 120000,
                            "jun" => 120000,
                            "jul" => 120000,
                            "aug" => 150000,
                            "sep" => 150000,
                            "oct" => 150000,
                            "nov" => 150000,
                            "dec" => 150000
                        ],
                        "annual" => 1331175.59
                    ]
                ],
                "expenses" => [
                    [
                        "year" => 2025,
                        "monthly" => [

                            "jan" => 83631.45,
                            "feb" => 61182.47,
                            "mar" => 91449.07,
                            "apr" => 77829.96,
                            "may" => 74280.95,
                            "jun" => 82700.31,
                            "jul" => 89540.22,
                            "aug" => 92910.55,
                            "sep" => 124411.55,
                            "oct" => 124412.45,
                            "nov" => 124413.45,
                            "dec" => 125162.37

                        ],
                        "annual" => 1111924.99
                    ]
                ],
                "profit" => [
                    [
                        "year" => 2025,
                        "monthly" => [
                            "jan" => -333.77,
                            "feb" => -28834.51,
                            "mar" => -45919.12,
                            "apr" => 22170.04,
                            "may" => 45719.05,
                            "jun" => 37299.69,
                            "jul" => 30459.78,
                            "aug" => 57089.45,
                            "sep" => 25588.45,
                            "oct" => 25587.45,
                            "nov" => 25586.45,
                            "dec" => 24837.63
                        ],
                        "annual" => 219250.6
                    ]
                ]
            ]
        ];
    }*/

    public function toArray($request) {
        return $this->collection->transform(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'title' => $item->title,
                'isIncome' => $item->isIncome,
                'values' => FinancialTypeValueResource::collection($item->values),
            ];
        });
    }
}
