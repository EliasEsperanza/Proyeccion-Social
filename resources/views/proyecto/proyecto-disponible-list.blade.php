@extends('layouts.appE')

@section('title', 'Lista de proyectos disponibles')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-disponible-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/gestor-de-TI.css') }}">
<link rel="stylesheet" href="{{ asset('css/solicitud-proyecto.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection
@section('content')

<div class="project-list">
    @forelse($proyectos as $proyecto)
        <div class="project-card">
            <h3>{{ $proyecto->nombre_proyecto }}</h3>
            <div class="info-item time">{{ $proyecto->horas_requeridas }} horas</div>
            <div class="info-item location">{{ $proyecto->lugar }}</div>
            <div class="detalles-proyecto">
                <p><strong>Sección:</strong> 
                    {{ $proyecto->seccion->nombre_seccion ?? 'Sin sección asignada' }}
                </p>
            </div>
            <div>
            <a href="{{ route('proyecto.ver', $proyecto->id_proyecto) }}" class="ver-mas">VER MÁS</a>
            </div>
            <button class="btn-enviar">Enviar solicitud</button>
        </div>
    @empty
        <p>No hay proyectos disponibles en este momento.</p>
    @endforelse
</div>

@endsection