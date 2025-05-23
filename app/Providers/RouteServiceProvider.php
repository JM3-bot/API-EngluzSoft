<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Definir as rotas da aplicação.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Definir as rotas de API.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api') // Prefixo 'api' para todas as rotas
            ->middleware('api') // Aplica o middleware 'api'
            ->group(base_path('routes/api.php')); // Roteamento do arquivo 'routes/api.php'
    }

    /**
     * Definir as rotas da web.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
