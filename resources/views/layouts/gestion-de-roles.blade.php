@extends('layouts.app')
@section('title', 'Gestión de Roles')
@section('content')
<style>
    .btn-custom {
        background-color: #8B0000;
        color: white;
        padding: 0.5rem 1.5rem; 
    }
    .pagination-custom .page-link {
        color: #8B0000;
        border: none;
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
    }
    .pagination-custom .page-item.active .page-link {
        background-color: #D3A7A0;
        color: #8B0000;
        font-weight: bold;
        border-radius: 8px;
        border: 2px solid #8B0000;
    }
    .container-custom {
        margin: 0 auto;
        max-width: 80%;
    }
    .card-equal-height {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .pagination-container {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        width: 100%;
    }
</style>
<div class="container container-custom my-5">
    <h2 class="my-4">Crear un nuevo rol</h2>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5>Detalles del nuevo rol</h5>
            <p class="text-muted">Definir un nuevo rol y sus permisos</p>
        </div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="nombreRol" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombreRol" placeholder="Ingrese el nuevo rol">
                </div>
                <div class="mb-3">
                    <label class="form-label">Permisos</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permiso1" checked>
                                <label class="form-check-label" for="permiso1">Gestión de usuarios</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permiso2">
                                <label class="form-check-label" for="permiso2">Usuarios</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permiso3">
                                <label class="form-check-label" for="permiso3">Publicar Proyectos</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permiso4">
                                <label class="form-check-label" for="permiso4">Gestión de permisos</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permiso5">
                                <label class="form-check-label" for="permiso5">Gestión de roles</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pagination-container">
                    <nav aria-label="Pagination" class="pagination-custom mb-2">
                        <ul class="pagination mb-0">
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </nav>
                    <button type="submit" class="btn btn-custom mt-2" style="width: auto;">Crear Rol</button>
                </div>
            </form>
        </div>
    </div>
    <h4 class="my-4">Roles Existentes</h4>
    @php
    // Array de datos de prueba para los roles existentes
    $roles = [
        [
            'name' => 'Administrador',
            'permissions' => [
                'Gestión de usuarios',
                'Usuarios',
                'Gestión de permisos',
                'Gestión de Roles',
            ]
        ],
        [
            'name' => 'Tutor',
            'permissions' => [
                'Gestión de usuarios',
                'Usuarios',
                'Publicar Proyectos',
            ]
        ]
    ];
    @endphp
    <div class="row">
        @foreach ($roles as $role)
            <div class="col-md-6">
                <div class="card mb-4 card-equal-height">
                    <div class="card-body d-flex flex-column">
                        <h5>Rol: {{ $role['name'] }}</h5>
                        <p class="text-muted">Permisos asignados a este rol</p>
                        <hr class="mb-2">
                        <ul>
                            @foreach ($role['permissions'] as $permission)
                                <li>{{ $permission }}</li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-end mt-auto">
                            <button class="btn btn-outline-warning btn-sm me-2">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection