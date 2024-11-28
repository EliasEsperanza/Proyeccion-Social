@extends('layouts.app')

@section('title', 'Editar proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/gestionProyecto.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    <script>
            Swal.fire({
                title: "¡Actualizado!",
                text: "El proyecto fue actualizado con éxito.",
                icon: "success",
                timer: 3000, 
                timerProgressBar: true, 
                didClose: () => {
                    // Opcional agregar algo
                }
            });
        </script>
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

<div class="container">
    <h1 class="mb-4">Editar Proyecto</h1>

    <div class="card w-100">
        <div class="card-body">
            <!-- Sección de Estudiantes -->
            <div class="mb-3">
                <label class="form-label">Estudiantes</label>

                <!-- Formulario para agregar estudiantes -->
                <form action="{{ route('proyectos.asignarEstudiante', $proyecto->id_proyecto) }}" method="POST" class="d-flex mb-3">
                    @csrf
                    <select class="form-select" id="idEstudiante" name="idEstudiante" >
                            @foreach ($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id_estudiante }}">
                                        {{ $estudiante->usuario->name }}
                                    </option>
                            @endforeach
                    </select>
                    <button type="submit" class="btn btn-light btn-sm p-2 px-3">
                        <i class="bi bi-plus"></i>
                    </button>
                </form>

                <!-- Lista de estudiantes asignados -->
                <ul class="list-unstyled">
                    @if ($proyecto->estudiantes->isNotEmpty())
                        @foreach ($proyecto->estudiantes as $estudiante)
                            <li class="d-flex align-items-center">
                                {{ $estudiante->usuario->name }}
                                <!-- Botón para eliminar estudiante -->
                                <form action="{{ route('proyectos.eliminarEstudiante', [$proyecto->id_proyecto, $estudiante->id_estudiante]) }}" method="POST" class="ms-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este estudiante?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    @else
                        <p>No hay estudiantes asignados</p>
                    @endif
                </ul>
            </div>
            <!-- Formulario principal -->
            <form action="{{ route('proyectos.actualizar', $proyecto->id_proyecto) }}" method="POST">
                @csrf
                @method('PUT') <!-- Método para actualización -->

                <div class="mb-3">
                    <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombreProyecto" name="nombre_proyecto" value="{{ $proyecto->nombre_proyecto }}" required>
                </div>

                <!-- Otros datos del proyecto -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tutor" class="form-label">Tutor</label>
                            <select class="form-select" id="idTutor" name="idTutor" >
                                @foreach ($tutores as $tutor)
                                    <option value="{{ $tutor->id_usuario }}" {{ $tutor->id_usuario == $proyecto->tutor ? 'selected' : '' }}>
                                        {{ $tutor->name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="lugar" value="{{ $proyecto->lugar }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio" value="{{ $proyecto->fecha_inicio }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fechaFinalizacion" class="form-label">Fecha de finalización</label>
                        <input type="date" class="form-control" id="fechaFinalizacion" name="fecha_fin" value="{{ $proyecto->fecha_fin }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ $estado->id_estado == $proyecto->estado ? 'selected' : '' }}>
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="id_seccion" class="form-label">Sección/Departamento</label>
                        <select name="seccion_id" class="form-select @error('departamento') is-invalid @enderror" id="seccion_id">
                            <option selected disabled>Seleccionar departamento</option>
                        @foreach($secciones as $seccion)
                            <option value="{{$seccion->id_seccion}}" {{ $seccion->id_seccion == $proyecto->seccion->id_seccion ? 'selected' : '' }}>
                                {{$seccion->nombre_seccion}}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-gestion fw-bold">Actualizar Proyecto</button>
            </form>
        </div>
    </div>
</div>
<div id="tutores-data" data-tutores='@json($tutores)'></div>
<div id="estudiantes-data" data-estudiantes='@json($estudiantes)'></div>
<script src="{{ asset('js/filtrarTutor.js') }}"></script>
<script src="{{ asset('js/filtrarEstudiantes.js') }}"></script>
<script src="{{ asset('js/gestionProyecto.js') }}"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Asociar el evento al formulario específico de actualización
    document.querySelector('form[action="{{ route("proyectos.actualizar", $proyecto->id_proyecto) }}"]').addEventListener('submit', function (event) {
        event.preventDefault(); // Evita el envío inmediato del formulario
        
        Swal.fire({
            title: "¡Actualización en proceso!",
            text: "El proyecto se está actualizando...",
            icon: "info",
            iconColor: '#800000',
            timer: 3000,
            confirmButtonText: 'OK',
            confirmButtonColor: '#800000',
            timerProgressBar: true,
            didClose: () => {
                // Este bloque se ejecuta después de cerrar la alerta
            }
        }).then(() => {
            event.target.submit(); // Envía el formulario después de la alerta
        });
    });
  });

  // Validar fechas: Asegurar que la fecha de finalización sea al menos 6 meses después de la fecha de inicio
  document.getElementById('fechaInicio').addEventListener('change', function () {
    const fechaInicio = this.value;
    const fechaFinInput = document.getElementById('fechaFinalizacion');

    if (fechaInicio) {
        const fechaInicioDate = new Date(fechaInicio);
        fechaInicioDate.setMonth(fechaInicioDate.getMonth() + 6);

        const minFechaFin = fechaInicioDate.toISOString().split('T')[0];

        fechaFinInput.min = minFechaFin;

        if (fechaFinInput.value < minFechaFin) {
            fechaFinInput.value = '';
        }
    }
  });
</script>

@endsection

