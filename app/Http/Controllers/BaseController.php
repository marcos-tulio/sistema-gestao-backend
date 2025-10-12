<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

abstract class BaseController extends Controller {

    abstract protected function getModel(): string;

    protected function getRelations(Request $request): array {
        return [];
    }

    protected function getRelationsCollection(Request $request): array {
        return [];
    }

    protected function getResourceRecord(): ?string {
        return null;
    }

    protected function getResourceCollection(): ?string {
        return null;
    }

    protected function getStoreRules(): array {
        return [];
    }

    protected function getUpdateRules(): array {
        return $this->getStoreRules();
    }

    protected function getSorts(): array {
        return ['id'];
    }

    protected function getStoreValidator(Request $request): array {
        return $request->validate($this->getStoreRules());
    }

    protected function getUpdateValidator(Request $request): array {
        return $request->validate($this->getUpdateRules());
    }

    protected function getStoreRequest(Request $request) {
        $request->headers->set('Accept', 'application/json');

        $input = $request->all();
        if (empty($input)) return response()->json(['message' => 'Nenhum campo informado'], 400);

        $allRules = $this->getStoreRules();
        $rules = array_intersect_key($allRules, $input);
        if (empty($rules)) return response()->json(['message' => 'Nenhum campo válido enviado'], 400);

        return $request;
    }

    protected function getUpdateRequest(Request $request) {
        $request->headers->set('Accept', 'application/json');

        $input = $request->all();
        if (empty($input)) return response()->json(['message' => 'Nenhum campo informado'], 400);

        $allRules = $this->getUpdateRules();
        $rules = array_intersect_key($allRules, $input);
        if (empty($rules)) return response()->json(['message' => 'Nenhum campo válido enviado'], 400);

        return $request;
    }

    protected function transformCollection($records) {
        $resource = $this->getResourceCollection();
        return $resource ? new $resource($records) : $records;
    }

    protected function transformRecord($record) {
        $resource = $this->getResourceRecord();
        return $resource ? new $resource($record) : $record;
    }

    protected function storeMiddleware($validated) {
        $record = $this->getModel()::create($validated);
        return $record;
    }

    protected function updateMiddleware($record, $validated) {
        $record->fill($validated);
        $record->save();
        return $record;
    }

    protected function sort($query, $sort, $order) {
        $query->orderBy($sort, $order);
        return $query;
    }

    public function destroy(string $id): JsonResponse {
        $record = $this->getModel()::find($id);
        if (!$record) return response()->json(['message' => 'Registro não encontrado.'], 404);

        if (isset($record->isDeletable) && !$record->isDeletable)
            return response()->json(['message' => 'O registro não pode ser apagado.'], 400);

        $record->delete();
        return response()->json(['message' => 'Registro apagado com sucesso.'], 200);
    }

    public function index(Request $request, $query = null) {
        $modelClass = $this->getModel();
        $query = $query ?: $modelClass::query();
        $query->with($this->getRelationsCollection($request));

        $table = (new $modelClass)->getTable();

        foreach ($request->all() as $param => $value) {
            if (in_array($param, ['_sort', '_order', '_page', '_limit']))
                continue;

            if (str_ends_with($param, '_like')) {
                $column = str_replace('_like', '', $param);

                if ($column === 'name')
                    $query->where('slug', 'like', '%' . Str::slug($value) . '%');

                else if (Schema::hasColumn($table, $column)) {
                    $query->where($column, 'like', '%' . $value . '%');
                }
            } else if (Schema::hasColumn($table, $param)) {
                $query->where($param, $value);
            }
        }

        $allowedSorts = $this->getSorts();
        $sort = $request->get('_sort', 'id');
        $order = strtolower($request->get('_order', 'asc'));

        if (in_array($sort, $allowedSorts)) {
            if (!in_array($order, ['asc', 'desc'])) $order = 'asc';
            $this->sort($query, $sort, $order);
        }

        $page = (int) $request->get('_page', 1);
        if ($page < 1) $page = 1;

        $limit = (int) $request->get('_limit', 50);
        if ($limit < 1 || $limit > 100) $limit = 15;

        try {
            $total = $query->count();
            $records = $query->forPage($page, $limit)->get();

            return response()
                ->json($this->transformCollection($records))
                ->header('X-Total-Count', $total);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Requisição inválida'], 400);
        }
    }

    public function show(string $id, Request $request) {
        try {
            $modelClass = $this->getModel();
            $record = $modelClass::with($this->getRelations($request))->find($id);

            if (!$record) return response()->json(['message' => 'Item não encontrado'], 404);

            return $this->transformRecord($record);
        } catch (\Exception $e) {
            return $this->errorHandler($e);
        }
    }

    public function store(Request $request) {
        try {
            $requestValidated = $this->getStoreRequest($request);
            if (!$requestValidated instanceof Request) return $requestValidated;

            $validated = $this->getStoreValidator($request);

            $record = $this->storeMiddleware($validated);
            if (!$record) return response()->json(['message' => 'Erro ao criar registro'], 500);

            return $this->transformRecord($record);
        } catch (\Exception $e) {
            return $this->errorHandler($e);
        }
    }

    public function update(Request $request, string $id) {
        try {
            $requestValidated = $this->getUpdateRequest($request);
            if (!$requestValidated instanceof Request) return $requestValidated;

            $validated = $this->getUpdateValidator($requestValidated);

            $record = $this->getModel()::find($id);
            if (!$record) return response()->json(['message' => 'Registro não encontrado.'], 404);

            if (isset($record->isEditable) && !$record->isEditable)
                return response()->json(['message' => 'O registro não pode ser editado.'], 400);

            $record = $this->updateMiddleware($record, $validated);

            return $this->transformRecord($record);
        } catch (\Exception $e) {
            return $this->errorHandler($e);
        }
    }

    protected function errorHandler(\Exception $e) {
        if ($e instanceof \Illuminate\Validation\ValidationException)
            return response()->json(['message' => 'Requisição inválida', 'errors' => $e->validator->errors()], 400);

        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
            return response()->json(['message' => 'Registro nao encontrado'], 404);

        if ($e->getCode() === '23505')
            return response()->json(['message' => 'Já existe um registro cadastrado com esses dados'], 409);

        return response()->json(['message' => 'Requisição inválida', 'error' => $e], 400);
    }
}
