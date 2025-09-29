<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /**
   * Muestra el formulario de inicio de sesión.
   */
  public function create()
  {
    return view('admin.auth.login');
  }

  /**
   * Procesa la autenticación del administrador.
   */
  public function store(Request $request)
  {
    // Validar los datos de entrada
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    // Intentar autenticar al usuario
    if (Auth::guard('admin')->attempt($credentials)) {
      $request->session()->regenerate();

      // Redirigir al dashboard de admin
      return redirect()->intended(route('admin.dashboard'));
    }

    // Si la autenticación falla, redirigir de vuelta con un mensaje de error
    return back()->withErrors([
      'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
  }

  /**
   * Cierra la sesión del administrador.
   */
  public function destroy(Request $request)
  {
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirigir a la página de inicio de sesión después de cerrar sesión
    return redirect()->route('admin.login');
  }
}
