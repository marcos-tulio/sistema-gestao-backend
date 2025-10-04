<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinancialCollectionResource;
use App\Http\Resources\FinancialResource;
use App\Models\Financial;
use Illuminate\Http\Request;

/**
 * @deprecated
 */
class FinancialController extends BaseController {

    protected function getModel(): string {
        return Financial::class;
    }

    protected function getResourceCollection(): ?string {
        return FinancialCollectionResource::class;
    }

    /*protected function getResourceRecord(): ?string {
        return FinancialResource::class;
    }*/

    protected function getRelationsCollection(Request $request): array {
        return ['categories'];
    }
}
