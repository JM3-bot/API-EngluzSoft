<?php

namespace App\Http\Controllers;

use App\Models\Visualizacao;
use Illuminate\Http\Request;

class VisualizacaoController extends Controller
{
    public function index($imovelId)
    {
        $total = Visualizacao::where('imovel_id', $imovelId)->count();

        return response()->json([
            'imovel_id' => $imovelId,
            'total_visualizacoes' => $total
        ], 200);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'imovel_id' => 'required|exists:imoveis,id',
        ]);

        $visualizacao = Visualizacao::create($dados);

        return response()->json([
            'mensagem' => 'Visualização registrada com sucesso!',
            'dados' => $visualizacao
        ], 201);
    }
}
