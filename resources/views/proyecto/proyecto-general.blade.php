@extends('layouts.app')

@section('title', 'Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
<h1>Proyectos</h1>
<form id="proyectosForm" action="{{ route('proyectos.generar') }}" method="POST">
    @csrf
    <input type="hidden" name="action" id="actionInput">

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
                @foreach($ListProyecto as $proyecto)
                    <tr>
                        <td><input type="checkbox" name="proyectos[]" value="{{ $proyecto->id_proyecto }}"></td>
                        <td>{{ $proyecto->nombre_proyecto }}</td>
                        <td>
                            @if($proyecto->estudiantes->isNotEmpty())
                                @foreach($proyecto->estudiantes as $estudiante)
                                    <li>{{ $estudiante->usuario->name }}</li>
                                @endforeach
                            @else
                                <p>No hay estudiantes asignados</p>
                            @endif
                        </td>
                        <td>{{ $proyecto->tutorr?->name ?? 'Sin tutor asignado' }}</td>
                        <td>{{ $proyecto->fecha_inicio }}</td>
                        <td>{{ $proyecto->fecha_fin }}</td>
                        <td>{{ $proyecto->lugar }}</td>
                        <td>-</td>
                        <td>{{ $proyecto->estadoo->nombre_estado }}</td>
                        <td>{{ $proyecto->seccion->nombre_seccion }}</td>
                        <td>
                            <!-- Botón de edición -->
                            <a href="{{ route('proyecto.proyecto-editar', ['id' => $proyecto->id_proyecto]) }}" class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-pencil text-warning"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="p-3 d-flex flex-column flex-md-row justify-content-between align-items-center bg-light border-top">
            <span class="text-muted mb-2 mb-md-0">Mostrando 1 a 10 de 50 resultados</span>
            <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>10</option>
                    <option>20</option>
                    <option>50</option>
                </select>
                <span>por página</span>
            </div>
            <ul class="paginacion d-flex gap-2 mb-0">
                <li class="pagina-item activo">
                    <a class="pagina-enlace" href="#">1</a>
                </li>
                <li class="pagina-item"><a class="pagina-enlace" href="#">2</a></li>
                <li class="pagina-item"><a class="pagina-enlace" href="#">3</a></li>
                <li class="pagina-item"><a class="pagina-enlace" href="#">4</a></li>
                <li class="pagina-item"><a class="pagina-enlace" href="#">5</a></li>
                <li class="pagina-item"><a class="pagina-enlace" href="#"><i class="bi bi-chevron-right"></i></a></li>
            </ul>
        </div>
        </div>
        <div class="d-flex justify-content-end">
            <div class="button-group mt-3 px-4 mb-4">
                <button type="button" onclick="return submitForm('pdf')" class="btn btn-success me-2">Generar PDF</button>
                <button type="button" onclick="return submitForm('excel')" class="btn btn-primary">Generar Excel</button>
                <button type="button" onclick="return submitForm('delete')" class="btn btn-danger">Eliminar Seleccionados</button>
            </div>
        </div>
    </div>
</form>
<script>
  function submitForm(action) {
    const form = document.getElementById('proyectosForm');
    const actionInput = document.getElementById('actionInput');
    const selectedItems = document.querySelectorAll('input[name="proyectos[]"]:checked');

    // Mapeo de acciones a mensajes personalizados
    const actionMessages = {
        'pdf': 'generar un PDF',
        'excel': 'generar un Excel',
        'delete': 'eliminar proyectos'
    };

    // Validación de selección
    if (selectedItems.length === 0) {
        alert(`Por favor, selecciona al menos un proyecto para ${actionMessages[action]}.`);
        return false; // Detiene la propagación del evento y previene otras alertas
    }

    // Confirmación para eliminación
    if (action === 'delete') {
        const confirmDelete = confirm(`¿Estás seguro de que deseas eliminar los ${selectedItems.length} proyectos seleccionados?`);
        if (!confirmDelete) {
            return false; // Detiene la ejecución si no se confirma
        }
    }

    // Configurar acción
    actionInput.value = action;

    // Enviar formulario
    form.submit();
    return false; // Asegura que no se propague el evento
}
</script>

<script src="{{ asset('js/proyecto-general.js') }}"></script>
@endsection