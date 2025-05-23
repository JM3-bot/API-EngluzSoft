<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use Illuminate\Http\Request;

class MensagemController extends Controller
{
    public function index($usuarioId)
    {
        // Busca mensagens enviadas ou recebidas pelo usuário
        $mensagens = Mensagem::where('remetente_id', $usuarioId)
            ->orWhere('destinatario_id', $usuarioId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($mensagens, 200);
    }

    public function show($id)
    {
        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['erro' => 'Mensagem não encontrada'], 404);
        }

        return response()->json($mensagem, 200);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'remetente_id' => 'required|exists:usuarios,id',
            'destinatario_id' => 'required|exists:usuarios,id',
            'conteudo' => 'required|string|max:1000',
        ]);

        $mensagem = Mensagem::create($dados);

        return response()->json([
            'mensagem' => 'Mensagem enviada com sucesso!',
            'dados' => $mensagem
        ], 201);
    }

    public function destroy($id)
    {
        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['erro' => 'Mensagem não encontrada'], 404);
        }

        $mensagem->delete();

        return response()->json(['mensagem' => 'Mensagem excluída com sucesso!'], 200);
    }
}
