<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function index($imovelId)
    {
        $avaliacoes = Avaliacao::where('imovel_id', $imovelId)->get();

        return response()->json($avaliacoes, 200);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'imovel_id' => 'required|exists:imoveis,id',
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        $avaliacao = Avaliacao::create($dados);

        return response()->json([
            'mensagem' => 'Avaliação criada com sucesso!',
            'dados' => $avaliacao
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $avaliacao = Avaliacao::find($id);

        if (!$avaliacao) {
            return response()->json(['erro' => 'Avaliação não encontrada'], 404);
        }

        $dados = $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        $avaliacao->update($dados);

        return response()->json([
            'mensagem' => 'Avaliação atualizada com sucesso!',
            'dados' => $avaliacao
        ], 200);
    }

    public function destroy($id)
    {
        $avaliacao = Avaliacao::find($id);

        if (!$avaliacao) {
            return response()->json(['erro' => 'Avaliação não encontrada'], 404);
        }

        $avaliacao->delete();

        return response()->json(['mensagem' => 'Avaliação excluída com sucesso!'], 200);
    }
}
