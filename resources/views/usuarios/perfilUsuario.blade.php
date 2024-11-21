@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/registro.css') }}">
@endsection

@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="card-title mb-4">
                <i class="bi bi-person me-2"></i> Información de perfil
            </h5>
            <form class="d-flex flex-column align-items-center" action="{{route('update_usuario', $usuario->id_usuario)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3 w-50">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{$usuario->name}}">
                    @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 w-50">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" value="{{$usuario->email}}" readonly>
                </div>
                <div class="mb-3 w-50">
                    <label for="rol" class="form-label">Rol</label>
                    <input type="text" class="form-control" id="rol" value="{{ $usuario->getRoleNames()->first() ?? 'Sin rol' }}" readonly>
                </div>
                <button type="submit" class="btn-custom">Aceptar cambios</button>
            </form>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="card-title mb-3">
                <i class="bi bi-lock me-2"></i> Actualizar contraseña
            </h5>
            <p class="text-muted mb-4 text-color">
                Asegúrese que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.
            </p>

            <form id="passwordForm" action="{{ route('update_password') }}" class="d-flex flex-column align-items-center" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Contraseña actual -->
                <div class="mb-3 w-40">
                    <label for="contrasena_actual" class="form-label">Contraseña actual</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock icono-candado"></i></span>
                        <input type="password"
                            class="form-control @error('contrasena_actual') is-invalid @enderror"
                            id="contrasena_actual"
                            name="contrasena_actual"
                            placeholder="Ingrese su contraseña actual"
                            required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="contrasena_actual">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('contrasena_actual')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nueva contraseña -->
                <div class="mb-3 w-40">
                    <label for="nueva_contrasena" class="form-label">Nueva contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock icono-candado"></i></span>
                        <input type="password" 
                            class="form-control @error('nueva_contrasena') is-invalid @enderror" 
                            id="nueva_contrasena" 
                            name="nueva_contrasena" 
                            placeholder="Ingrese su nueva contraseña"
                            required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="nueva_contrasena">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <div class="form-text">
                        La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales.
                    </div>
                    @error('nueva_contrasena')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmar nueva contraseña -->
                <div class="mb-3 w-40">
                    <label for="nueva_contrasena_confirmation" class="form-label">Confirmar contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock icono-candado"></i></span>
                        <input type="password" 
                            class="form-control" 
                            id="nueva_contrasena_confirmation" 
                            name="nueva_contrasena_confirmation" 
                            placeholder="Confirme su nueva contraseña"
                            required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="nueva_contrasena_confirmation">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-custom">
                    Actualizar contraseña
                </button>
            </form>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    @foreach ($errors->all() as $error)
    <div class="toast show mb-2 overflow-hidden border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="toast-header bg-danger text-white">
            <i class="bi bi-exclamation-circle me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body border-start border-danger border-4">
            {{ $error }}
        </div>
    </div>
    @endforeach
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/actpassperfil.js') }}"></script>
@endsection