<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;

class ImovelController extends Controller
{
    public function index()
    {
        $imoveis = Imovel::with(['usuario', 'caracteristicas', 'fotos'])->get();
        return response()->json($imoveis, 200);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'endereco' => 'required|string',
            'cidade' => 'required|string',
            'provincia ' => 'required|string',
            'tipo' => 'required|in:casa,apartamento,terreno,comercial',
            'area' => 'nullable|numeric',
        ]);

        $imovel = Imovel::create($dados);

        return response()->json([
            'mensagem' => 'Imóvel criado com sucesso!',
            'dados' => $imovel
        ], 201);
    }

    public function show($id)
    {
        $imovel = Imovel::with(['usuario', 'caracteristicas', 'fotos'])->find($id);

        if (!$imovel) {
            return response()->json(['erro' => 'Imóvel não encontrado'], 404);
        }

        return response()->json($imovel, 200);
    }

    public function update(Request $request, $id)
    {
        $imovel = Imovel::find($id);

        if (!$imovel) {
            return response()->json(['erro' => 'Imóvel não encontrado'], 404);
        }

        $dados = $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'descricao' => 'sometimes|string',
            'preco' => 'sometimes|numeric',
            'endereco' => 'sometimes|string',
            'cidade' => 'sometimes|string',
            'estado' => 'sometimes|string',
            'tipo' => 'sometimes|in:casa,apartamento,terreno,comercial',
            'area' => 'nullable|numeric',
        ]);

        $imovel->update($dados);

        return response()->json([
            'mensagem' => 'Imóvel atualizado com sucesso!',
            'dados' => $imovel
        ], 200);
    }

    public function destroy($id)
    {
        $imovel = Imovel::find($id);

        if (!$imovel) {
            return response()->json(['erro' => 'Imóvel não encontrado'], 404);
        }

        $imovel->delete();

        return response()->json(['mensagem' => 'Imóvel excluído com sucesso!'], 200);
    }
}
