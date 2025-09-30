<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinancialCategoryResource extends JsonResource {

    public static $wrap = null;

    public function toArray($request) {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'order' => $this->order,
            'items' => [
                [
                    "id" => 1,
                    "title" => "Comissão",
                    "values" => [
                        [
                            "year" => 2025,
                            "monthly" => [
                                "jan" => 319,
                                "feb" => 120,
                                "mar" => 96,
                                "apr" => 96,
                                "may" => 564,
                                "jun" => 2000,
                                "jul" => 2000,
                                "aug" => 2000,
                                "sep" => 2000,
                                "oct" => 2000,
                                "nov" => 2000,
                                "dec" => 2000
                            ]
                        ]
                    ],
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
                ]
            ]
        ];
    }
}
