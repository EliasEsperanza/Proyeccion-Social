@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
    <div class="container-fluid mt-1">
        <h2 class="text-start mb-4">Crear Nuevo Usuario</h2>
        
        <div class="card p-4 shadow-sm">
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Nombre">
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" id="correo" placeholder="example@ues.edu.sv">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
                        <button class="btn btn-outline-secondary" type="button" id="showPassword">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" class="form-select @error('rol') is-invalid @enderror" id="rol">
                        <option selected>Seleccionar Rol</option>
                        <option value="administrador">administrador</option>
                        <option value="tutor">tutor</option>
                        <option value="estudiante">estudiante</option>
                        <option value="coordinador">coordinador</option>
                    </select>
                </div>
            </div>
            <div class="mb-4 row">
                <div class="col-md-6">
                    <label for="id_seccion" class="form-label">Sección/Departamento</label>
                    <select name="id_seccion" class="form-select @error('departamento') is-invalid @enderror" id="id_seccion">
                        <option selected>Seleccionar departamento</option>
                    @foreach($secciones as $seccion)
                        <option value="{{$seccion->id_seccion}}">{{$seccion->nombre_seccion}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary w-100 mb-3 fw-bold">Crear Usuario</button>
            </div>
    </form>
        </div>
    </div>

    <!-- validacion de errores -->
    @if ($errors->any())
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast show align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
@endsection
