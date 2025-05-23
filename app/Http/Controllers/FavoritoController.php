<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function index($usuarioId)
    {
        $favoritos = Favorito::with('imovel')
            ->where('usuario_id', $usuarioId)
            ->get();

        return response()->json($favoritos, 200);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'imovel_id' => 'required|exists:imoveis,id',
        ]);

        $existe = Favorito::where('usuario_id', $dados['usuario_id'])
            ->where('imovel_id', $dados['imovel_id'])
            ->first();

        if ($existe) {
            return response()->json(['mensagem' => 'Este imóvel já está nos favoritos.'], 200);
        }

        $favorito = Favorito::create($dados);

        return response()->json([
            'mensagem' => 'Imóvel adicionado aos favoritos!',
            'dados' => $favorito
        ], 201);
    }

    public function destroy(Request $request)
    {
        $dados = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'imovel_id' => 'required|exists:imoveis,id',
        ]);

        $favorito = Favorito::where('usuario_id', $dados['usuario_id'])
            ->where('imovel_id', $dados['imovel_id'])
            ->first();

        if (!$favorito) {
            return response()->json(['erro' => 'Favorito não encontrado.'], 404);
        }

        $favorito->delete();

        return response()->json(['mensagem' => 'Imóvel removido dos favoritos.'], 200);
    }
}
