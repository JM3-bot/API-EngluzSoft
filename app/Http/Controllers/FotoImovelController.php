<?php

namespace App\Http\Controllers;

use App\Models\FotoImovel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoImovelController extends Controller
{
    public function index($imovelId)
    {
        $fotos = FotoImovel::where('imovel_id', $imovelId)->get();

        return response()->json($fotos, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'imovel_id' => 'required|exists:imoveis,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $caminho = $request->file('foto')->store('fotos_imoveis', 'public');

        $foto = FotoImovel::create([
            'imovel_id' => $request->imovel_id,
            'caminho' => $caminho
        ]);

        return response()->json([
            'mensagem' => 'Foto enviada com sucesso!',
            'dados' => $foto
        ], 201);
    }

    public function destroy($id)
    {
        $foto = FotoImovel::find($id);

        if (!$foto) {
            return response()->json(['erro' => 'Foto não encontrada'], 404);
        }

        Storage::disk('public')->delete($foto->caminho);
        $foto->delete();

        return response()->json(['mensagem' => 'Foto excluída com sucesso!'], 200);
    }
}
