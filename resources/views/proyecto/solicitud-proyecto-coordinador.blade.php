@extends('layouts.app')

@section('title', 'Solicitudes de proyectos')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/solicitud-proyecto.css') }}">
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<h1>Solicitudes de proyectos</h1>

<div class="">
    @foreach($proyectos as $proyecto)
    <div class="card">
        <div class="title">{{ $proyecto->nombre_proyecto }}</div>

        <div class="subtitle">
            @if($proyecto->estudiantes->isNotEmpty())
            @foreach($proyecto->estudiantes as $estudiante)
            ID Usuario: {{ $estudiante->id_usuario }} <br>
            @endforeach
            @else
            No hay estudiantes disponibles.
            @endif
        </div>
        
        <!--<div class="subtitle" id="nombreEstudiante">-</div>-->


        <div class="info-item time">{{ $proyecto->horas_requeridas }} horas</div>
        <div class="info-item location">{{ $proyecto->lugar }}</div>

        <a class="ver-mas" href="{{ route('gestor_de_TI') }}" onclick="establecerActivo(this)">Ver más</a>
        <div class="actions">
            <button class="button accept" onclick="aceptarSolicitud()">Aceptar</button>
            <button class="button reject" onclick="rechazarSolicitud()">Rechazar</button>
        </div>
    </div>
    @endforeach
</div>

@endsection

@section('scripts')
<script>
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