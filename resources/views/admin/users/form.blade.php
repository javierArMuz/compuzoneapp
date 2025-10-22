@extends('layouts.admin')

@section('title', isset($user) ? 'Editar Usuario' : 'Crear Usuario')

@section('content')
<div class="container-fluid py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white py-3 rounded-top-3">
          <h4 class="mb-0">{{ isset($user) ? 'Editar Usuario: ' . $user->first_name : 'Crear Nuevo Usuario' }}</h4>
        </div>
        <div class="card-body p-4">
          {{-- Lógica para determinar si es CREATE o UPDATE --}}
          <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST">
            @csrf
            {{-- Si es edición, se necesita el método PUT --}}
            @if(isset($user))
            @method('PUT')
            @endif

            {{-- Campo Nombre --}}
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">Nombre Completo</label>
              <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('first_name', $user->first_name ?? '') }}" required>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Campo Email --}}
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email ?? '') }}" required>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Campo Contraseña (solo si es nuevo o si se quiere cambiar) --}}
            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Contraseña
                @if(isset($user)) <small class="text-muted">(Dejar vacío para no cambiar)</small> @endif
              </label>
              <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                @if(!isset($user)) required @endif>
              @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Campo Confirmar Contraseña --}}
            <div class="mb-3">
              <label for="password_confirmation" class="form-label fw-semibold">Confirmar Contraseña</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                @if(!isset($user)) required @endif>
            </div>

            {{-- Campo Rol --}}
            <!-- <div class="mb-4">
              <label for="role" class="form-label fw-semibold">Rol</label>
              <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="">Seleccione un Rol</option>
                @php $currentRole = old('role', $user->role ?? ''); @endphp
                <option value="admin" {{ $currentRole === 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="client" {{ $currentRole === 'client' ? 'selected' : '' }}>Cliente</option>
              </select>
              @error('role')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div> -->

            <div class="d-flex justify-content-between">
              <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Cancelar
              </a>
              <button type="submit" class="btn btn-primary shadow-sm">
                <i class="fas fa-save me-2"></i> {{ isset($user) ? 'Actualizar Usuario' : 'Crear Usuario' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection