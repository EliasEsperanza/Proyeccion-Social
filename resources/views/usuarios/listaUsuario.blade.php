@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('/css/UsuariosList.css') }}">

<div class="container-fluid mt-1">
    <h2 class="text-start mb-4">Usuarios</h2>
    <div class="card shadow-sm p-4" style="border-radius: 12px; overflow: hidden;">

        <!-- Formulario de búsqueda -->
        <form method="GET" action="{{ route('usuarios') }}" class="d-flex justify-content-between align-items-center mb-3">
            <button type="submit" class="btn btn-danger btn-eliminar" form="deleteForm">
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
                                        <button type="submit" class="btn btn-light btn-sm p-2 px-3 delete-button">
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

    
 //ALERTA DE ELIMINAR USUARIO INDIVIDUAL
 document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('click', function (e) {
            if (e.target.closest('.delete-button')) {
                e.preventDefault();
                const form = e.target.closest('form');
                Swal.fire({
                    html: `        <p>¡No podrás revertir esto!</p>
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px;">
            <defs>
                <linearGradient id="gradient" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#800000" />
                    <stop offset="100%" stop-color="#e91d53" />
                </linearGradient>
            </defs>
            <path d="M3 6h18M9 6v12M15 6v12M19 6v16H5V6z" />
        </svg>
    `,
    title: '¿Estás seguro?',
    showCancelButton: true,
    confirmButtonColor: '#800000',
    cancelButtonColor: '#C7C8CC',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
    customClass: {
        popup: 'custom-swal-popup' 
    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                        Swal.fire({
                            title: "ELiminado!",
                            text: "El Usuario fue elimando con exito.",
                            icon: "success",
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#800000'
    }); 
                    }
                });
            }
        });
    });

     //ALERTA DE ELIMINAR TODOS LOS USUARIOS SELECCIONADOS
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', function (e) {
        if (e.target.closest('.btn-eliminar')) {
            e.preventDefault();

            // Verificar si hay al menos un usuario seleccionado
            const checkboxes = document.querySelectorAll('input[name="users[]"]');
            let isChecked = false;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    isChecked = true;
                }
            });

            if (!isChecked) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Por favor, seleccione al menos un usuario para eliminar.",
                });
                return; // Detener la ejecución del resto de la función
            }
            Swal.fire({
                html: `
                    <p>¡No podrás revertir esto!</p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="url(#gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 48px; height: 48px;">
                        <defs>
                            <linearGradient id="gradient" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#800000" />
                                <stop offset="100%" stop-color="#e91d53" />
                            </linearGradient>
                        </defs>
                        <path d="M3 6h18M9 6v12M15 6v12M19 6v16H5V6z" />
                    </svg>
                `,
                title: '¿Estás seguro de eliminar a todos los usuarios seleccionados?',
                showCancelButton: true,
                confirmButtonColor: '#800000',
                cancelButtonColor: '#C7C8CC',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    popup: 'custom-swal-popup' 
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                    Swal.fire({
                            title: "ELiminado!",
                            text: "El Usuario fue elimando con exito.",
                            icon: "success",
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#800000'
    }); 
                }
            });
        }
    });
});

</script>
@endsection
