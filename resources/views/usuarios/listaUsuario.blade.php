@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<style>
    .w-5, .h-5 {
        width: 1rem;
        height: 1rem;
    }
    div p.text-sm.text-gray-700.leading-5.dark\:text-gray-400 {
        display: none;
    }
    .flex.justify-between.flex-1.sm\:hidden > span,
    .flex.justify-between.flex-1.sm\:hidden > a {
        display: none;
    }
    .form-control {
        border: 1px solid #800000;
        border-radius: 5px;
    }
    .form-control:focus {
        box-shadow: 0 0 3px #800000;
    }
  
    .btn-eliminar {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .input-d{
    width: 20px;
    height: 20px;
    border: 2px solid #ced4da !important;
    border-radius: 4px !important;
    cursor: pointer;
    transition: all 0.3s ease;
    }

    .input-d:checked {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25)!important;
    }
    .icon-d{
        background: #800000;
        color: #fff !important;
        padding: 0.49rem 0.8rem ;
    }

    .icon-d i{
        color: #fff !important; 
    }
    
</style>

<div class="container-fluid mt-1">
    <h2 class="text-start mb-4">Usuarios</h2>
    <div class="card shadow-sm p-4" style="border-radius: 12px; overflow: hidden;">

        <!-- Formulario de búsqueda -->
        <form method="GET" action="{{ route('usuarios') }}" class="d-flex justify-content-between align-items-center mb-3">
            <button type="submit" class="btn btn-danger btn-eliminar" form="deleteForm" onclick="return confirm('¿Estás seguro de que deseas eliminar los usuarios seleccionados?')">
                <i class="fa-solid fa-trash-can"></i> Eliminar seleccionados
            </button>
            
            <div class="input-group ms-auto w-25">
                <span class="input-group-text icon-d">
                    <i class="bi bi-search "></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar">
                <button type="submit" class="input-group-text bg-light border-0">
                    <i class="fas fa-filter custom-filter-icon"></i>
                </button>
            </div>
            <!-- Selector de filtro de rol -->
            <div class="ms-2">
                <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Todos los roles</option>
                    <option value="estudiante" {{ request('role') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                    <option value="tutor" {{ request('role') == 'tutor' ? 'selected' : '' }}>Tutor</option>
                    <option value="coordinador" {{ request('role') == 'coordinador' ? 'selected' : '' }}>Coordinador</option>
                    <option value="administrador" {{ request('role') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>
        </form>

        <!-- Formulario de eliminación -->
        <form method="POST" action="{{ route('usuarios.eliminar') }}" id="deleteForm">
            @csrf
            @method('DELETE')

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col"><input type="checkbox" class="input-d"  id="selectAll"></th>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo Electrónico</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Sección/Departamento</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $usuario)
                        <tr>
                            <td><input type="checkbox" class="form-check-input " name="users[]" value="{{ $usuario->id_usuario }}"></td>
                            <td>{{ $usuario->id_usuario }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if (method_exists($usuario, 'getRoleNames'))
                                    {{ $usuario->getRoleNames()->first() ?? 'Sin rol' }}
                                @else
                                    {{ $usuario->user_role ?? 'Sin rol' }}
                                @endif
                            </td>

                            <td>{{ $usuario->seccion }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('usuarios.editarUsuario', ['id' => $usuario->id_usuario]) }}" class="btn btn-light btn-sm p-2 px-3"><i class="bi bi-pencil text-warning"></i></a>
                                    <form method="POST" action="{{ route('usuarios.eliminarUsuario', ['id' => $usuario->id_usuario]) }}" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm p-2 px-3" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('perfil', ['id' => $usuario->id_usuario]) }}" class="btn btn-light btn-sm p-2 px-3"><i class="bi bi-eye text-muted"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Paginación y selección de resultados por página -->
        <form method="GET" action="{{ route('usuarios') }}" class="d-flex justify-content-between align-items-center mt-3">
            <p class="mb-0">Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }} resultados</p>
            
            <div class="d-flex align-items-center">
                <select name="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span class="ms-2">por página</span>
            </div>

            <div class="rounded-pagination-wrapper" id="paginationWrapper">
                <div class="pagination-container pag page-item">
                    {{ $users->appends(['search' => request('search'), 'per_page' => request('per_page')])->links() }}
                </div>
            </div>
        </form>
    </div>
</div>

<script>
 document.getElementById('selectAll').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('input[name="users[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});
</script>
@endsection
