<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Schema;

abstract class BaseController extends Controller {

    abstract protected function getModel(): string;

    protected function getRules(): array {
        return [];
    }

    protected function getSorts(): array {
        return ['id'];
    }

    protected function getValidator(Request $request): array {
        return $request->validate($this->getRules());
    }

    public function destroy(string $id): JsonResponse {
        $record = $this->getModel()::find($id);

        if (!$record)
            return response()->json(['message' => 'Registro não encontrado.'], 404);

        $record->delete();

        return response()->json(['message' => 'Registro deletado com sucesso.'], 200);
    }

    public function index(Request $request) {
        $modelClass = $this->getModel();
        $query = $modelClass::query();
        $table = (new $modelClass)->getTable();

        foreach ($request->all() as $param => $value) {
            if (in_array($param, ['_sort', '_order', '_page', '_limit']))
                continue;

            if (str_ends_with($param, '_like')) {
                $column = str_replace('_like', '', $param);
                if (Schema::hasColumn($table, $column)) {
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
            $query->orderBy($sort, $order);
        }

        $page  = (int) $request->get('_page', 1);
        if ($page < 1) $page = 1;

        $limit = (int) $request->get('_limit', 50);
        if ($limit < 1 || $limit > 100) $limit = 15;

        $total = $query->count();
        $records = $query->forPage($page, $limit)->get();

        return response()
            ->json($records)
            ->header('X-Total-Count', $total);
    }

    public function show(string $id) {
        $record = $this->getModel()::find($id);

        if (!$record)
            return response()->json(['message' => 'Item não encontrado'], 404);

        return response()->json($record);
    }

    public function store(Request $request) {
        $request->headers->set('Accept', 'application/json');

        $validated = $this->getValidator($request);

        $record = $this->getModel()::create($validated);

        return response()->json($record, 201);
    }

    public function update(Request $request, string $id) {
        $request->headers->set('Accept', 'application/json');

        $record = $this->getModel()::find($id);
        if (!$record)
            return response()->json(['message' => 'Registro não encontrado.'], 404);

        $input = $request->all();
        if (empty($input))
            return response()->json(['message' => 'Nenhum campo informado'], 400);

        $allRules = $this->getRules();
        $rules = array_intersect_key($allRules, $input);

        if (empty($rules))
            return response()->json(['message' => 'Nenhum campo válido enviado'], 400);

        $validated = $request->validate($rules);

        $record->fill($validated);
        $record->save();

        return response()->json($record, 200);
    }
}
