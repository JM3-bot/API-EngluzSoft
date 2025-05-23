<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        // Mapear 'senha' para 'password' para autenticar
        $credentials = [
            'email' => $dados['email'],
            'password' => $dados['senha'],
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json(['erro' => 'Credenciais inválidas'], 401);
        }

        $usuario = Auth::user();

        // Cria token pessoal para API via Sanctum
        $token = $usuario->createToken('token_api')->plainTextToken;

        return response()->json([
            'usuario' => $usuario,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['mensagem' => 'Logout realizado com sucesso!'], 200);
    }
}
