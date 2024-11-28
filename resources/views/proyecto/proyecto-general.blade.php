@extends('layouts.app')

@section('title', 'Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<h1>Proyectos en Curso</h1>
<form id="proyectosForm" action="{{ route('proyectos.generar') }}" method="POST">
    @csrf
    <input type="hidden" name="action" id="actionInput">

    @php
    // Configuración de la paginación
    $page = request('page', 1); // Página actual
    $perPage = request('perPage', 10); // Número de elementos por página, por defecto 10
    $total = $ListProyecto->count(); // Total de elementos
    $paginatedProjects = $ListProyecto->slice(($page - 1) * $perPage, $perPage); // Elementos para la página actual
    $totalPages = ceil($total / $perPage); // Total de páginas
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <span>Elementos por página:</span>
        <select id="perPageSelect" class="form-select w-auto">
            <option value="5" {{ request('perPage', 10) == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ request('perPage', 10) == 20 ? 'selected' : '' }}>20</option>
            <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50</option>
        </select>
    </div>

    <div class="tabla-contenedor shadow-sm rounded bg-white">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="selectAll"></th>
                        <th>Título del proyecto</th>
                        <th>Estudiantes</th>
                        <th>Tutor</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de finalización</th>
                        <th>Ubicación</th>
                        <th>Progreso</th>
                        <th>Estado</th>
                        <th>Sección/Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paginatedProjects as $proyecto)
                    <tr>
                        <td><input type="checkbox" name="proyectos[]" value="{{ $proyecto->id_proyecto }}"></td>
                        <td>{{ $proyecto->nombre_proyecto }}</td>
                        <td>
                            @if($proyecto->estudiantes->isNotEmpty())
                            <ul>
                                @foreach($proyecto->estudiantes as $estudiante)
                                <li>{{ $estudiante->usuario->name }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p>No hay estudiantes asignados</p>
                            @endif
                        </td>
                        <td>{{ $proyecto->tutorr?->name ?? 'Sin tutor asignado' }}</td>
                        <td>{{ $proyecto->fecha_inicio }}</td>
                        <td>{{ $proyecto->fecha_fin }}</td>
                        <td>{{ $proyecto->lugar }}</td>
                        <td>{{ $proyecto->estudiantes->first()?->porcentaje_completado ?? 'N/A' }} %</td>
                        <td>{{ $proyecto->estadoo->nombre_estado }}</td>
                        <td>{{ $proyecto->seccion->nombre_seccion }}</td>
                        <td>

                            <!--Boton de solicitudes-->
                            <a href="{{ route('solicitudesProyectos', ['id' => $proyecto->id_proyecto]) }}"
                                class="btn btn-light btn-sm p-2 px-3 mb-2">
                                <i class="fa-solid fa-circle-exclamation"></i>
                            </a>
                            <!-- Botón de edición -->
                            <a href="{{ route('proyecto.proyecto-editar', ['id' => $proyecto->id_proyecto]) }}"
                                class="btn btn-light btn-sm p-2 px-3">
                                <i class="fa fa-pencil text-warning"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">No hay proyectos disponibles.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 d-flex justify-content-between align-items-center bg-light border-top">
            <span class="text-muted mb-2 mb-md-0">
                Mostrando {{ ($page - 1) * $perPage + 1 }} a {{ min($page * $perPage, $total) }} de {{ $total }} resultados
            </span>
            <div>
                <ul class="pagination">
                    @for ($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $i == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i, 'perPage' => $perPage]) }}">{{ $i }}</a>
                        </li>
                        @endfor
                </ul>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <div class="button-group mt-3 px-4 mb-4">
            <button type="button" onclick="return submitForm('pdf')" class="btn btn-animated btn-success me-2">
                <i class="fa-solid fa-file-pdf"></i> Generar PDF
            </button>
            <button type="button" onclick="return submitForm('excel')" class="btn btn-animated btn-primary">
                <i class="fa-solid fa-file-excel"></i> Generar Excel
            </button>
            <button type="button" onclick="return submitForm('delete')" class="btn btn-delete btn-danger">
                <i class="fa-solid fa-trash-can"></i> Eliminar Seleccionados
            </button>
        </div>
    </div>
</form>

<script>
    function submitForm(action) {
    const form = document.getElementById('proyectosForm');
    const actionInput = document.getElementById('actionInput');
    const selectedItems = document.querySelectorAll('input[name="proyectos[]"]:checked');

    if (selectedItems.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, selecciona al menos un proyecto para realizar esta acción.',
            confirmButtonText: 'Aceptar'
        });
        return false;
    }

    if (action === 'delete') {
        Swal.fire({
            html: `      
            <P>¿Estás seguro de que deseas eliminar el proyecto seleccionado?</P>  
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
            title: 'Confirmación',
            showCancelButton: true,
            confirmButtonColor: '#800000',
            cancelButtonColor: '#C7C8CC',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                actionInput.value = action;
                form.submit();
                Swal.fire({
                            title: "ELiminado!",
                            text: "El proyecto fue elimando con exito.",
                            icon: "success",
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#800000'
    }); 
            }
        });
        return false;
    }

    if (action === 'pdf' || action === 'excel') {
        Swal.fire({
            icon: 'info',
            title: 'Generando',
            text: `Generando ${action === 'pdf' ? 'PDF' : 'Excel'}...`,
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            actionInput.value = action;
            form.submit();
        });
        return false;
    }
    actionInput.value = action;
    form.submit();
    return false;
}

    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="proyectos[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    document.getElementById('perPageSelect').addEventListener('change', function() {
        const perPage = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', perPage);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    });
</script>
@endsection