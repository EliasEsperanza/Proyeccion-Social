@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container-fluid mt-1">
    <h2 class="text-start mb-4">Crear Nuevo Usuario</h2>

    <div class="card p-4 shadow-sm">
        <form id="crearUsuarioForm" action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Nombre" >
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" id="correo" placeholder="example@ues.edu.sv" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
                        <button class="btn btn-outline-secondary" type="button" id="showPassword">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" class="form-select @error('rol') is-invalid @enderror" id="rol" required>
                        <option selected>Seleccionar Rol</option>
                        @if(auth()->check() && auth()->user()->hasRole('Coordinador'))
                        <option value="Tutor">Tutor</option>
                        <option value="Estudiante">Estudiante</option>
                        @else
                        <option value="Administrador">Administrador</option>
                        <option value="Coordinador">Coordinador</option>
                        <option value="Tutor">Tutor</option>
                        <option value="Estudiante">Estudiante</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="mb-4 row">
                <div class="col-md-6">
                    <label for="id_seccion" class="form-label">Sección/Departamento</label>
                    <select name="id_seccion" class="form-select @error('departamento') is-invalid @enderror" id="id_seccion" required>
                        <option selected>Seleccionar departamento</option>
                        @foreach($secciones as $seccion)
                        @if (Auth::user()->hasRole('Coordinador'))
                        @php
                        $seccionId = Auth::user()->getDepartamentoCoordinador();
                        @endphp

                        @if ($seccion->id_seccion == $seccionId)
                        <option value="{{ $seccion->id_seccion }}">{{ $seccion->nombre_seccion }}</option>
                        @break
                        @endif
                        @else
                        <option value="{{ $seccion->id_seccion }}">{{ $seccion->nombre_seccion }}</option>
                        @endif
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="d-grid">
                <button id="submitButton" type="submit" class="btn btn-primary w-100 mb-3 fw-bold">
                    Crear Usuario
                </button>
            </div>
        </form>

    </div>
</div>

<script src="{{asset('js/crearUsuarioScript.js')}}"></script>

@endsection