<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class BaseController extends Controller {

    abstract protected function getModel(): string;

    abstract protected function getRules(): array;

    abstract protected function getValidator(Request $request): array;

    public function destroy(string $id): JsonResponse {
        $record = $this->getModel()::find($id);

        if (!$record)
            return response()->json(['message' => 'Registro não encontrado.'], 404);

        $record->delete();

        return response()->json(['message' => 'Registro deletado com sucesso.'], 200);
    }

    public function index() {
        return $this->getModel()::all();
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
