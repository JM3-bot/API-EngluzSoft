<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    // Listar todos os imóveis com user, fotos e features
    public function index()
    {
        $properties = Property::with(['user', 'photos', 'features'])->get();
        return response()->json($properties);
    }
    public function indexview()
    {
        $properties = Property::with(['user', 'photos', 'features'])->get();
        return response()->json($properties);
    }

    // Cadastrar novo imóvel
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipo_imovel' => 'required|string',
            'tipo_transacao' => 'required|string',
            'titulo' => 'required|string',
            'descricao' => 'nullable|string',
            'quartos' => 'nullable|integer',
            'banheiros' => 'nullable|integer',
            'area_util' => 'nullable|numeric',
            'area_total' => 'nullable|numeric',
            'endereco' => 'required|string',
            'provincia' => 'required|string',
            'municipio' => 'required|string',
            'preco' => 'required|numeric',
            'telefone_contato' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $property = Property::create($validated);

        return response()->json($property, 201);
    }

    // Mostrar imóvel por ID
    public function show($id)
    {
        $property = Property::with(['user', 'photos', 'features'])->findOrFail($id);
        return response()->json($property);
    }

    // Atualizar imóvel
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $validated = $request->validate([
            'tipo_imovel' => 'sometimes|required|string',
            'tipo_transacao' => 'sometimes|required|string',
            'titulo' => 'sometimes|required|string',
            'descricao' => 'nullable|string',
            'quartos' => 'nullable|integer',
            'banheiros' => 'nullable|integer',
            'area_util' => 'nullable|numeric',
            'area_total' => 'nullable|numeric',
            'endereco' => 'sometimes|required|string',
            'provincia' => 'sometimes|required|string',
            'municipio' => 'sometimes|required|string',
            'preco' => 'sometimes|required|numeric',
            'telefone_contato' => 'sometimes|required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $property->update($validated);

        return response()->json($property);
    }

    // Deletar imóvel
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return response()->json(null, 204);
    }




    // Cadastrar novo imóvel
    public function imoveis(Request $request)
    {
        $validated = $request->all();

        $property = Property::create($validated);

        return response()->json($property, 201);
    }

    public function indexpro(Request $request)
    {
        $Id = $request->input('id');
        $query = Property::with(['user', 'photos', 'features'])
        ->whereHas('user', function($q) use ($Id) {
            $q->where('id', $Id);
        })
        ->get();



        return response()->json($query);
    }
    //atualizar
     public function imovelstore(Request $request)
    {
       // Verifica se o imóvel existe
    $property = Property::find($request->id);
    if (!$property) {
        return response()->json(['error' => 'Imóvel não encontrado.'], 404);
    }

    // Verifica se existem arquivos de fotos
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            // Armazena a imagem
            $path = $request->file('photos')->store('public/photos');
            $path = str_replace('public/', 'storage/', $path);

            // Insere no banco de dados
            DB::table('property_photos')->insert([
                'property_id' => $property->id,
                'path' => $path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return response()->json(['message' => 'Fotos salvas com sucesso.']);
    }

    return response()->json(['message' => 'Nenhuma foto enviada.']);
        $dados_imoveis = [
            "area_total"=> $request->area_total,
            "area_util"=> $request->area_util,
            "banheiros"=> $request->banheiros,
            "descricao"=> $request->descricao,
            "endereco"=> $request->endereco,
            "latitude"=> $request->latitude,
            "longitude"=> $request->longitude,
            "municipio"=> $request->municipio,
            "preco"=> $request->preco,
            "provincia"=> $request->provincia,
            "quartos"=> $request->quartos,
            "telefone_contato"=> $request->telefone_contato,
            "tipo_imovel"=> $request->tipo_imovel,
            "tipo_transacao"=> $request->tipo_transacao,
            "titulo"=> $request->titulo,
        ];
        $imovel = Property::where('id', $request->id)->update($dados_imoveis);

        return response()->json([
            'message' => 'Imóvel cadastrado com sucesso!',
        ], 201);
    }
}
