<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    public function index($usuarioId)
    {
        $visitas = Visita::with('imovel')
            ->where('usuario_id', $usuarioId)
            ->orderBy('data_hora', 'asc')
            ->get();

        return response()->json($visitas, 200);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'imovel_id' => 'required|exists:imoveis,id',
            'data_hora' => 'required|date|after:now'
        ]);

        $visita = Visita::create($dados);

        return response()->json([
            'mensagem' => 'Visita agendada com sucesso!',
            'dados' => $visita
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $visita = Visita::find($id);

        if (!$visita) {
            return response()->json(['erro' => 'Visita não encontrada'], 404);
        }

        $dados = $request->validate([
            'data_hora' => 'required|date|after:now'
        ]);

        $visita->update($dados);

        return response()->json([
            'mensagem' => 'Visita atualizada com sucesso!',
            'dados' => $visita
        ], 200);
    }

    public function destroy($id)
    {
        $visita = Visita::find($id);

        if (!$visita) {
            return response()->json(['erro' => 'Visita não encontrada'], 404);
        }

        $visita->delete();

        return response()->json(['mensagem' => 'Visita cancelada com sucesso!'], 200);
    }
}
