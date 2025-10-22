<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  /**
   * Muestra la lista de usuarios.
   */
  public function index()
  {
    // Se obtiene una lista paginada de todos los usuarios
    $users = User::orderBy('id', 'desc')->paginate(10);
    return view('admin.users.index', compact('users'));
  }

  /**
   * Muestra el formulario para crear un nuevo usuario.
   */
  public function create()
  {
    return view('admin.users.form');
  }

  /**
   * Almacena un nuevo usuario en la base de datos.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'role' => ['required', Rule::in(['admin', 'client'])],
    ]);

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
    ]);

    return redirect()->route('admin.users.index')
      ->with('success', 'Usuario creado exitosamente.');
  }

  /**
   * Muestra el formulario para editar un usuario existente.
   */
  public function edit(User $user)
  {
    // Se pasa el objeto $user a la misma vista de formulario
    return view('admin.users.form', compact('user'));
  }

  /**
   * Actualiza el usuario especificado en la base de datos.
   */
  public function update(Request $request, User $user)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      // El email debe ser único, pero se debe ignorar el email actual del usuario
      'email' => [
        'required',
        'string',
        'email',
        'max:255',
        Rule::unique('users')->ignore($user->id),
      ],
      // La contraseña es opcional al editar, pero si se envía, debe tener un mínimo
      'password' => 'nullable|string|min:8|confirmed',
      'role' => ['required', Rule::in(['admin', 'client'])],
    ]);

    $userData = [
      'name' => $request->name,
      'email' => $request->email,
      'role' => $request->role,
    ];

    // Solo se actualiza la contraseña si se proporciona una nueva
    if ($request->filled('password')) {
      $userData['password'] = Hash::make($request->password);
    }

    $user->update($userData);

    return redirect()->route('admin.users.index')
      ->with('success', 'Usuario actualizado exitosamente.');
  }

  /**
   * Elimina el usuario especificado.
   */
  public function destroy(User $user)
  {
    // Por seguridad, se debe evitar que un usuario se elimine a sí mismo
    if (Auth::user()->id === $user->id) {
      return redirect()->route('admin.users.index')
        ->with('error', 'No puedes eliminar tu propia cuenta mientras estás logueado.');
    }

    $user->delete();

    return redirect()->route('admin.users.index')
      ->with('success', 'Usuario eliminado exitosamente.');
  }
}
