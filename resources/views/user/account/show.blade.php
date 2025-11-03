@extends('layouts.user')

@section('content')
<div class="container py-5">
  <h2 class="mb-5 fw-bold text-primary border-bottom pb-2"><i class="fa-solid fa-user"></i> Mi Cuenta</h2>

  {{-- Mensaje de éxito/error --}}
  @if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="row">
    {{-- Formulario de actualización de datos --}}
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">Datos Personales y Acceso</div>
        <div class="card-body">
          <form method="POST" action="{{ route('account.update') }}">
            @csrf

            {{-- Campo Nombre --}}
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('first_name', $user->first_name) }}" required>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Campo Email --}}
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <hr>

            {{-- Sección de Cambio de Contraseña --}}
            <h5 class="mt-4">Cambiar Contraseña (Opcional)</h5>
            <div class="mb-3">
              <label for="password" class="form-label">Nueva Contraseña</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
              @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection