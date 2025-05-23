<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImovelController;
use App\Http\Controllers\CaracteristicaController;
use App\Http\Controllers\FotoImovelController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\VisualizacaoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\AuthController;

// ROTAS PÚBLICAS
Route::apiResource('imoveis', ImovelController::class)->only(['index', 'show']);
Route::get('/caracteristicas', [CaracteristicaController::class, 'index']);
Route::get('/imoveis/{id}/fotos', [FotoImovelController::class, 'index']);
Route::get('/imoveis/{id}/avaliacoes', [AvaliacaoController::class, 'index']);
Route::get('/imoveis/{id}/visualizacoes', [VisualizacaoController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// ROTAS PROTEGIDAS (autenticadas)
Route::middleware('auth:sanctum')->group(callback: function () {
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('imoveis', ImovelController::class)->except(['index', 'show']);

    Route::post('/fotos', [FotoImovelController::class, 'store']);
    Route::delete('/fotos/{id}', [FotoImovelController::class, 'destroy']);

    Route::get('/usuarios/{usuarioId}/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos', [FavoritoController::class, 'store']);
    Route::delete('/favoritos', [FavoritoController::class, 'destroy']);

    Route::post('/caracteristicas', [CaracteristicaController::class, 'store']);
    Route::put('/caracteristicas/{id}', [CaracteristicaController::class, 'update']);
    Route::delete('/caracteristicas/{id}', [CaracteristicaController::class, 'destroy']);

    Route::get('/usuarios/{usuarioId}/mensagens', [MensagemController::class, 'index']);
    Route::get('/mensagens/{id}', [MensagemController::class, 'show']);
    Route::post('/mensagens', [MensagemController::class, 'store']);
    Route::delete('/mensagens/{id}', [MensagemController::class, 'destroy']);

    Route::get('/usuarios/{usuarioId}/visitas', [VisitaController::class, 'index']);
    Route::post('/visitas', [VisitaController::class, 'store']);
    Route::put('/visitas/{id}', [VisitaController::class, 'update']);
    Route::delete('/visitas/{id}', [VisitaController::class, 'destroy']);

    Route::post('/visualizacoes', [VisualizacaoController::class, 'store']);

    Route::post('/avaliacoes', [AvaliacaoController::class, 'store']);
    Route::put('/avaliacoes/{id}', [AvaliacaoController::class, 'update']);
    Route::delete('/avaliacoes/{id}', [AvaliacaoController::class, 'destroy']);
});
