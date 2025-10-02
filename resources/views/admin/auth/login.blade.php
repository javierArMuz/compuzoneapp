@extends('layouts.auth')

@section('title', 'Admin | Iniciar Sesión')

@section('content')
<div class="col-md-7 col-lg-5">
  <div class="card shadow p-4">
    <h2 class="card-title text-center">Iniciar Sesión</h2>
    <h5 class="text-center mb-4">(Admin)</h5>

    <!-- Mensajes de sesión (éxito o error) -->
    @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
    @endif

    <!-- Errores de validación -->
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- Formulario de Login -->
    <form method="POST" action="{{ route('admin.login.store') }}">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
      </div>
    </form>
  </div>
</div>
@endsection