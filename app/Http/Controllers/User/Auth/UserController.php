<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

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
      'password' => ['required', 'confirmed', Password::defaults()],
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

  /**
   * Muestra la vista del perfil de usuario "Mi Cuenta".
   */
  public function showAccount()
  {
    // El usuario autenticado está disponible a través de Auth::user()
    $user = Auth::user();

    return view('user.account.show', compact('user'));
  }

  /**
   * Procesa la actualización de los datos del perfil.
   */
  public function updateAccount(Request $request)
  {

    $user = Auth::user();

    // Verificación de tipo de objeto (Debugging)
    if (!($user instanceof User)) {
      // Si entra aquí, significa que $user NO es el modelo de Eloquent.
      dd('ERROR FATAL: El objeto $user no es una instancia del modelo User.');
    }

    // 1. Validación de los datos
    $request->validate([
      'name' => 'required|string|max:255',
      // Asegura que el email es único, excluyendo el email actual del usuario
      'email' => [
        'required',
        'string',
        'email',
        'max:255',
        Rule::unique('users')->ignore($user->id),
      ],
      // La contraseña es opcional, solo si quiere cambiarla
      'password' => 'nullable|string|min:8|confirmed',
    ]);

    // 2. Actualización de datos básicos
    $user->first_name = $request->input('name');
    $user->email = $request->input('email');

    // 3. Actualización de la contraseña (solo si se ha proporcionado)
    if ($request->filled('password')) {
      $user->password = bcrypt($request->input('password'));
    }

    $user->save();

    // 4. Redireccionar con un mensaje de éxito
    return redirect()->route('account.show')->with('success', 'Tu perfil se ha actualizado correctamente.');
  }

  // Cierra la sesión del usuario
  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home')->with('success', 'Sesión cerrada exitosamente.');
  }
}
