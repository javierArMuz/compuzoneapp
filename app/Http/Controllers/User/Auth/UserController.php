<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
  // Muestra el formulario de registro de usuario
  public function create()
  {
    return view('user.auth.register');
  }

  // Procesa el formulario de registro y crea el usuario
  public function store(Request $request)
  {
    // 1. Validación de datos
    $request->validate([
      'first_name' => ['required', 'string', 'max:100'],
      'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'last_name' => ['nullable', 'string', 'max:100'],
      'phone' => ['nullable', 'string', 'max:15'],
      'address' => ['nullable', 'string'],
    ]);

    // 2. Crear el usuario
    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'password' => Hash::make($request->password), // Hashear la contraseña antes de guardar
      'phone' => $request->phone,
      'address' => $request->address,
      'registration_date' => now()->toDateString(),
    ]);

    // 3. Autenticar y redirigir
    Auth::login($user);

    // Redirigir a una ruta segura, por ejemplo, el dashboard del usuario o la página principal
    return redirect()->route('dashboard')->with('success', '¡Registro exitoso! Bienvenido a CompuzoneApp.');
  }

  // Muestra el formulario de inicio de sesión
  public function login()
  {
    return view('user.auth.login');
  }

  // Procesa la solicitud de inicio de sesión
  public function authenticate(Request $request)
  {
    // 1. Validar las credenciales
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    // 2. Intentar autenticar al usuario
    if (Auth::attempt($credentials, $request->remember)) {
      $request->session()->regenerate();

      // Redirigir a la página de inicio
      return redirect()->intended(route('dashboard'))->with('success', '¡Has iniciado sesión correctamente!');
    }

    // 3. Si falla, devolver error
    return back()->withErrors([
      'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
    ])->onlyInput('email');
  }

  // Cierra la sesión del usuario
  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('auth.login')->with('success', 'Sesión cerrada exitosamente.');
  }
}
