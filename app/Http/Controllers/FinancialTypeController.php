<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinancialTypeCollectionResource;
use App\Models\FinancialType;
use Illuminate\Http\Request;

class FinancialTypeController extends BaseController {

    protected function getModel(): string {
        return FinancialType::class;
    }

    protected function getResourceCollection(): ?string {
        return FinancialTypeCollectionResource::class;
    }

    protected function getSorts(): array {
        return [
            'id',
            'title',
            'values.year'
        ];
    }

    protected function getRelationsCollection(Request $request): array {
        $years = $request->input('year');

        if (!$years) return ['values'];

        return ['values' => function ($q) use ($years) {
            if ($years) $q->whereIn('year', (array) $years);
        }];
    }
}
