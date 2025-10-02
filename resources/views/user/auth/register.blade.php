@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
    <div class="card shadow-lg" style="max-width: 550px; margin: auto;">
      <div class="card-header text-center">
        <h2 class="h4 m-0">Registro de Usuario</h2>
      </div>
      <div class="card-body p-4">

        {{--Formulario de Registro--}}
        <form method="POST" action="{{ route('auth.store') }}">
          @csrf

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="first_name" class="form-label">Nombre</label>
              <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required autofocus>
              {{--Muestra mensaje de error--}}
              @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="last_name" class="form-label">Apellido (Opcional)</label>
              <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
              @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
              @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
          </div>

          <div class="mb-4">
            <small class="text-muted">La contraseña debe tener al menos 8 caracteres.</small>
          </div>

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">Registrarse</button>
          </div>
        </form>

        {{--Opción de Inicio de Sesión desde aquí--}}
        <div class="text-center mt-3">
          <p class="mb-0">¿Ya tienes cuenta? <a href="{{ route('auth.login') }}">Inicia Sesión</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection