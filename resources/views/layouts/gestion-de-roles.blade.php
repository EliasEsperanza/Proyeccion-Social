@extends('layouts.app')
@section('title', 'Gestión de Roles')
@section('content')
<link rel="stylesheet" href="{{asset('css/gestionRoles.css')}}">


<div class="container container-custom my-5">
    <h2 class="my-4">Crear o Editar Rol</h2>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5>Detalles del rol</h5>
            <p class="text-muted">Definir un nuevo rol y sus permisos</p>
        </div>
        <div class="card-body">
            <form id="roleForm" action="{{ route('roles.store') }}" method="POST">
                @csrf
                <input type="hidden" id="roleId" name="role_id">
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="mb-3">
                    <label for="nombreRol" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombreRol" name="name" placeholder="Ingrese el nombre del rol" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Permisos</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}">
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contenedor para alinear los botones a la derecha -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-custom mt-2 me-2" id="createButton" >Crear Rol</button>
                    <button type="submit" class="btn btn-warning mt-2 me-2" id="updateButton" style="display: none;">Actualizar Rol</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Espacio adicional antes de la lista de roles existentes -->
    <div class="mt-5">
        <h4 class="my-4">Roles Existentes</h4>
        <div class="row">
            @foreach ($roles as $role)
                <div class="col-md-6">
                    <div class="card mb-4 card-equal-height">
                        <div class="card-body d-flex flex-column">
                            <h5>Rol: {{ $role->name }}</h5>
                            <p class="text-muted">Permisos asignados a este rol</p>
                            <hr class="mb-2">
                            <ul>
                                @foreach ($role->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-end mt-auto">
                                <button class="btn btn-outline-warning btn-sm me-2" 
                                        onclick="editRole({{ $role->id }}, '{{ addslashes($role->name) }}', {{ json_encode($role->permissions->pluck('name')) }})">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<script>
    function editRole(id, name, permissions) {
        // Cambiar el formulario a modo edición
        document.getElementById('roleId').value = id;
        document.getElementById('nombreRol').value = name;
        document.getElementById('formMethod').value = 'PUT';

        document.getElementById('roleForm').action = `/layouts/roles/${id}`;
        document.getElementById('createButton').style.display = 'none';
        document.getElementById('updateButton').style.display = 'inline-block';

        // Desmarcar todos los checkboxes y marcar solo los permisos del rol
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => checkbox.checked = false);
        permissions.forEach(permission => {
            const checkbox = document.querySelector(`input[value="${permission}"]`);
            if (checkbox) checkbox.checked = true;
        });

        // Desplazar hacia arriba al formulario
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    document.getElementById('roleForm').addEventListener('submit', function(event) {
        if (document.getElementById('roleId').value) {
            const methodInput = document.querySelector('input[name="_method"]');
            if (methodInput) methodInput.value = 'PUT';
        } else {
            // Cambiar al modo de creación
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('createButton').style.display = 'inline-block';
            document.getElementById('updateButton').style.display = 'none';
        }
    });
</script>
@endsection
