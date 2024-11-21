@extends('layouts.app')

@section('title', 'Detalle del Proyecto')

@section('content')
<div class="container-fluid d-flex justify-content-center mt-4">
    <div class="col-md-9 d-flex justify-content-center">
        <div class="card p-4 detail-card">
            <h2 class="text-center">{{ $proyecto->nombre_proyecto }}</h2>
            
            <h3>Descripción:</h3>
            <p>{{ $proyecto->descripcion_proyecto }}</p>
            
            <h4>Horas requeridas:</h4>
            <p>{{ $proyecto->horas_requeridas }}</p>
            
            <h4>Ubicación:</h4>
            <p>{{ $proyecto->lugar }}</p>
            
            <h4>Sección Departamento:</h4>
            <p>{{ $proyecto->seccion->nombre_seccion }}</p>
            
            <div class="button-container">
                <a href="{{ route('proyecto-disponible') }}" class="btn btn-secondary btn-return">Volver</a>
                <a href="{{ route('proyecto.descargar-pdf', ['id' => $proyecto->id_proyecto]) }}" class="btn btn-danger btn-pdf">Generar PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/detalle.css') }}" rel="stylesheet">
@endpush