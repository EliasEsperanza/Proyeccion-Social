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

        $progressClass = 'bg-danger';
        if ($porcentaje > 25) $progressClass = 'bg-warning';
        if ($porcentaje > 50) $progressClass = 'bg-info';
        if ($porcentaje > 75) $progressClass = 'bg-success';

        @endphp

        <div class="d-flex justify-content-between mb-2">
          <p class="card-text fw-bold">Progreso del Proyecto</p>
          <p class="text-muted">
            @if ($horasTotales == 0)
            Horas del proyecto pendientes de asignar.
            @else
            Completadas {{ $horasCompletadas }} de {{ $horasTotales }} horas.
            @endif
          </p>

        </div>

        <div class="progress" style="height: 25px;">
          <div
            class="progress-bar {{ $progressClass }} progress-bar-striped progress-bar-animated"
            role="progressbar"
            style="width: {{ $porcentaje }}%;"
            aria-valuenow="{{ $porcentaje }}"
            aria-valuemin="0"
            aria-valuemax="100">
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
          Horas Requeridas: {{ $horasTotales}}
        </p>
        <p class="card-text"><i class="bi bi-geo-alt-fill"></i></i>{{ $proyectoEstudiante->proyecto->lugar }}</p>
        <p class="card-text"><i class="bi bi-person-fill"></i>Tutor: {{ $proyectoEstudiante->proyecto->tutorr ? $proyectoEstudiante->proyecto->tutorr->name : 'Sin asignar' }}</p> <button class="btn-verde btn m-3">{{ $proyectoEstudiante->proyecto->estadoos->nombre_estado }}</button>
      </div>

      <!-- Buttons -->
      <div class="d-flex justify-content-between p-3">
        <!-- muestra boton hasta que el proyecto sea aprobado -->
        @if ( $proyectoEstudiante->proyecto->estado == 10)
        <a class="btn-actualizar btn" href="{{ route('estudiante.actualizarHorasView') }}">Actualizar horas</a>
        @endif

        <a href="{{ route('detallesmio') }}" class="btn-detalles btn">Ver Detalles</a>
      </div>
    </div>
  </div>
</div>
@endsection