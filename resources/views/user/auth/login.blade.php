@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-5 col-md-7">
    <div class="card shadow-lg" style="max-width: 450px; margin: auto;">
      <div class="card-header text-center">
        <h2 class="h4 m-0">Iniciar Sesión</h2>
      </div>
      <div class="card-body p-4">

        {{-- Muestra mensajes de error de sesión --}}
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          Las credenciales proporcionadas no coinciden con nuestros registros.
        </div>
        @endif

        {{-- Muestra mensaje de éxito (ej. al cerrar sesión) --}}
        @if(session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
        @endif

        {{-- Formulario de Login --}}
        <form method="POST" action="{{ route('auth.authenticate') }}">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            {{--Muestra mensaje de error--}}
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-check mb-4">
            <input type="checkbox" name="remember" id="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Recordarme</label>
          </div>

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">Acceder</button>
          </div>
        </form>

        {{--Opción de Registrarse desde aquí--}}
        <div class="text-center mt-3">
          <p class="mb-0">¿No tienes cuenta? <a href="{{ route('auth.register') }}">Regístrate aquí</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection