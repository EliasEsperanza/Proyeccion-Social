@extends('layouts.appE')

@section('title', 'Detalles del Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-disponibleE.css') }}">
@endsection

@section('content')

<div class="container py-5">
    <div class="card shadow tarjeta-detalle mx-auto" style="max-width: 800px;">
        <div class="card-body p-4">
            <h2 class="titulo-proyecto mb-4 text-center">{{ $proyecto->nombre_proyecto }}</h2>
            <p class="descripcion mb-3">
                <strong>Descripción:</strong> {{ $proyecto->descripcion_proyecto }}
            </p>
            <div class="detalles-proyecto">
                <p><strong>Horas requeridas:</strong> {{ $proyecto->horas_requeridas }}</p>
                <p><strong>Ubicación:</strong> {{ $proyecto->lugar }}</p>
                <p><strong>Sección:</strong> {{ $proyecto->seccion->nombre ?? 'Sin sección asignada' }}</p>
                <p><strong>Estado:</strong> {{ $proyecto->estadoo->nombre_estado ?? 'Sin estado definido' }}</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-enviar me-2">Enviar solicitud</button>
                <a href="{{ route('estudiantes.dashboard') }}" class="btn btn-regresar">Regresar</a>
            </div>
        </div>
    </div>
</div>

@endsection
