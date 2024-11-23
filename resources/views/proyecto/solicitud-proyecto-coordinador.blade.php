@extends('layouts.app')

@section('title', 'Solicitudes de proyectos')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/solicitud-proyecto.css') }}">
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<h1 style=" margin-left: 30px;">Solicitudes de proyectos</h1>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="gap: 15px; margin-left: 60px;">
    @foreach($proyectos as $proyecto)
    <div class="card">
        <div class="title">{{ $proyecto->nombre_proyecto }}</div>

        <div class="subtitle">
            @if($proyecto->estudiantes->isNotEmpty())

            Estudiantes asignados:
            <ul>
                @foreach($proyecto->estudiantes as $estudiante)
                <li>
                    ID Estudiante: {{ $estudiante->id_estudiante }},
                    Nombre: {{ $estudiante->usuario ? $estudiante->usuario->name : 'No disponible' }}
                </li>
                @endforeach
            </ul>

            @else
            <p>No hay estudiantes disponibles.</p>
            @endif
        </div>

        <div class="info-item time">{{ $proyecto->horas_requeridas > 0 ? $proyecto->horas_requeridas . ' horas' : 'Sin asignar horas' }}</div>
        <div class="info-item location">{{ $proyecto->lugar }}</div>

        <a class="ver-mas" href="{{ route('detallesSolicitud', ['id_proyecto' => $proyecto->id_proyecto]) }}" onclick="establecerActivo(this)">Ver más</a>
        <div class="actions">
            <form action="{{ route('proyectos.aceptar', ['id_proyecto' => $proyecto->id_proyecto]) }}" method="POST" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-success">Aceptar</button>
            </form>
            <form action="{{ route('proyectos.rechazar', ['id_proyecto' => $proyecto->id_proyecto]) }}" method="POST" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-danger">Rechazar</button>
            </form>
        </div>
    </div>
    @endforeach
</div>

@endsection

@section('scripts')
<script>
    // Cargar estudiantes por sección
    fetch(`/obtenerNombreEstudiante/{id}`)
        .then(response => response.json())
        .then(estudiantes => {
            estudiantes.forEach(estudiante => {
                const option = document.createElement('option');
                option.value = estudiante.id_estudiante;
                option.textContent = estudiante.usuario.name;
                selectEstudiantes.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar estudiantes:', error));

    // Función para manejar el clic en "Ver más"
    function establecerActivo(element) {
        // Cambiar el estado del enlace o agregar alguna acción, si es necesario
    }

    // Funciones para aceptar y rechazar la solicitud
    function aceptarSolicitud() {
        console.log('Solicitud aceptada');
    }

    function rechazarSolicitud() {
        console.log('Solicitud rechazada');
    }

    const estudianteId = estudiantes.length > 0 ? estudiantes[0].id_estudiante : null;

    if (estudianteId) {
        fetch(`/obtenerNombreEstudiante/${estudianteId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('error de red');
                }
                return response.json();
            })
            .then(data => {
                const nombre = data ? data.name : 'Nombre no encontrado';
                document.getElementById('nombreEstudiante').innerText = nombre;
            })
            .catch(error => {
                console.error('Hubo un problema con la solicitud fetch:', error);
                document.getElementById('nombreEstudiante').innerText = 'Error al cargar el nombre';
            });
    } else {
        document.getElementById('nombreEstudiante').innerText = 'No hay estudiantes disponibles';
    }
</script>
@endsection