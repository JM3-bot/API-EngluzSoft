<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica;
use Illuminate\Http\Request;

class CaracteristicaController extends Controller
{
    public function index()
    {
        $caracteristicas = Caracteristica::all();
        return response()->json($caracteristicas, 200);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|unique:caracteristicas|max:255',
        ]);

        $caracteristica = Caracteristica::create($dados);

        return response()->json([
            'mensagem' => 'Característica criada com sucesso!',
            'dados' => $caracteristica
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $caracteristica = Caracteristica::find($id);

        if (!$caracteristica) {
            return response()->json(['erro' => 'Característica não encontrada'], 404);
        }

        $dados = $request->validate([
            'nome' => 'required|string|max:255|unique:caracteristicas,nome,' . $id,
        ]);

        $caracteristica->update($dados);

        return response()->json([
            'mensagem' => 'Característica atualizada com sucesso!',
            'dados' => $caracteristica
        ], 200);
    }

    public function destroy($id)
    {
        $caracteristica = Caracteristica::find($id);

        if (!$caracteristica) {
            return response()->json(['erro' => 'Característica não encontrada'], 404);
        }

        $caracteristica->delete();

        return response()->json(['mensagem' => 'Característica excluída com sucesso!'], 200);
    }
}
