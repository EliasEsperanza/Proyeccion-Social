@extends('layouts.appE')

@section('title', 'Mi Proyecto')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/miproyectostudent.css') }}">

@endsection

@section('content')
<div class="container mt-2">
  <h1 class="card-title mb-4 text-rigth">Mi proyecto de horas sociales</h1>
  <div class="card shadow-m">
    <div class="card-body">

      <h2>{{ $proyectoEstudiante->proyecto->nombre_proyecto }}</h2>

      <!-- Progress bar -->
      <div class="my-4">
        @php
            $porcentaje = optional($proyectoEstudiante)->porcentaje_completado ?? 0;
        @endphp
        <div class="d-flex justify-content-between">
            <p class="card-text">Progreso del Proyecto</p>
            <p>Completadas {{ $proyectoEstudiante->horas_sociales_completadas ?? 0 }} de {{ $proyectoEstudiante->proyecto->horas_requeridas }} horas</p>
        </div>  
        <div class="progress" style="height: 20px;">
            <div 
                class="progress-bar" 
                role="progressbar"
                style="width: {{ $porcentaje }}%;"
                aria-valuenow="{{ $porcentaje }}"
                aria-valuemin="0"
                aria-valuemax="100"
            >
                {{ $porcentaje }}%
            </div>
        </div>
    </div>

      <div class="mr-4">
      <p class="card-text">
          <i class="bi bi-calendar"></i>
          Inicio: {{ \Carbon\Carbon::parse($proyectoEstudiante->proyecto->fecha_inicio)->translatedFormat('d F Y') }}
        </p>
        <p class="card-text">
          <i class="bi bi-calendar-event"></i>
          Fin: {{ \Carbon\Carbon::parse($proyectoEstudiante->proyecto->fecha_fin)->translatedFormat('d F Y') }}
        </p>
        <p class="card-text">
          <i class="bi bi-clock"></i>
          Horas Requeridas: {{ $proyectoEstudiante->proyecto->horas }}
        </p>
        <p class="card-text"><i class="bi bi-geo-alt-fill"></i></i>{{ $proyectoEstudiante->proyecto->lugar }}</p>
        <p class="card-text"><i class="bi bi-person-fill"></i>Tutor: {{ $proyectoEstudiante->proyecto->tutorr ? $proyectoEstudiante->proyecto->tutorr->name : 'Sin asignar' }}</p>        <button class="btn-verde btn m-3">{{ $proyectoEstudiante->proyecto->estadoos->nombre_estado }}</button>
      </div>

      <!-- Buttons -->
      <div class="d-flex justify-content-between p-3">
      <a class="btn-actualizar btn" href="{{ route('estudiante.actualizarHorasView') }}">Actualizar horas</a>
        <a href="{{ route('detallesmio') }}" class="btn-detalles btn">Ver Detalles</a>
      </div>
    </div>
  </div>
</div>
@endsection