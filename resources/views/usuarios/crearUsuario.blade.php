@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
    <div class="container-fluid mt-1">
        <h2 class="text-start mb-4">Crear Nuevo Usuario</h2>
        
        <div class="card p-4 shadow-sm">
            <form>
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                    </div>
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" placeholder="example@ues.edu.sv">
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="Contraseña">
                            <button class="btn btn-outline-secondary" type="button" id="showPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" id="rol">
                            <option selected>Seleccionar Rol</option>
                            <option value="admin">Admin</option>
                            <option value="usuario">Usuario</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-md-6">
                        <label for="departamento" class="form-label">Sección/Departamento</label>
                        <select class="form-select" id="departamento">
                            <option selected>Seleccionar departamento</option>
                            <option value="departamento1">Departamento 1</option>
                            <option value="departamento2">Departamento 2</option>
                        </select>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary w-100 mb-3 fw-bold">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
@endsection
