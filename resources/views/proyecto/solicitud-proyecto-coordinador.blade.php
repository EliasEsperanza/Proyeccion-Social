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
            <div class="subtitle">{{ $proyecto->descripcion_proyecto }}</div>
            <div class="info-item time">{{ $proyecto->horas_requeridas }} horas</div>
            <div class="info-item location">{{ $proyecto->lugar }}</div>
            <div class="info-item coordinator">Coordinador: {{ $proyecto->coordinador }}</div>
            <div class="info-item tutor">Tutor: {{ $proyecto->tutor }}</div>
            <div class="info-item date">
                Fecha de inicio: {{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d-m-Y') }}<br>
                Fecha de fin: {{ \Carbon\Carbon::parse($proyecto->fecha_fin)->format('d-m-Y') }}
            </div>
            <div class="info-item status">
                Estado: {{ $proyecto->estado }}
            </div>
            <div class="info-item period">Periodo: {{ $proyecto->periodo }}</div>
            <a class="ver-mas" href="{{ route('gestor_de_TI', ['nombre_proyecto' => $proyecto->nombre_proyecto]) }}" onclick="establecerActivo(this)">Ver más</a>
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
</script>
@endsection
