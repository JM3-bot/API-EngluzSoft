<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Listar todos os usuários
    public function index()
    {
        return response()->json(User::all());
    }

    // Criar um novo usuário
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'telefone_contato' => 'nullable|string|max:20',
                'password' => 'required|string|min:6|confirmed',
                'tipo' => 'required|in:proprietario,agente,administrador',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], 500);
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    // Mostrar um usuário específico
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Atualizar um usuário
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'telefone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'tipo' => 'sometimes|required|in:proprietario,agente,administrador',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    // Deletar um usuário
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
