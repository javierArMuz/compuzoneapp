<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * The path to your application's "home" route.
   *
   * Typically, users are redirected here after authentication.
   *
   * @var string
   */
  public const HOME = '/home'; // Puedes cambiar esto si se tiene una ruta de inicio diferente para usuarios logueados

  /**
   * Define your route model bindings, pattern filters, and other route configuration.
   */
  public function boot(): void
  {
    // Define el límite de tasa para la API (60 peticiones por minuto por usuario/IP)
    RateLimiter::for('api', function (Request $request) {
      return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });

    $this->routes(function () {
      // Carga las rutas de la API, usando el prefijo 'api' y el middleware 'api'.
      // ESTO es lo que hace que /api/products funcione.
      Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));

      // Carga las rutas web (que incluyen tus rutas 'admin/*')
      Route::middleware('web')
        ->group(base_path('routes/web.php'));

      // Carga las rutas de admin con el middleware 'web' (para sesiones)
      // pero con su propio prefijo y archivo.
      Route::middleware('web')
        ->prefix('admin')
        ->name('admin.')
        ->group(base_path('routes/admin.php'));

      // Opcional: Carga las rutas de la consola si las tienes
      // Route::middleware('api')
      //    ->group(base_path('routes/sanctum.php'));
    });
  }
}
