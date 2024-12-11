@extends('layouts.appE')

@section('title', 'Detalles del Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/detallesProyecMio.css') }}">
@endsection

@section('content')

<div class="container mt-1">
  <h1 class="card-title mb-4 text-right">Detalles del Proyecto</h1>
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
          <div class="progress-bar {{ $progressClass }} progress-bar-striped progress-bar-animated" 
            role="progressbar"
            style="width: {{ $porcentaje }}%;"
            aria-valuenow="{{ $porcentaje }}"
            aria-valuemin="0"
            aria-valuemax="100">
            {{ $porcentaje }}%
          </div>
        </div>

      </div>

      <!-- Project details -->
      <div class="mr-4">
        <p class="card-text">
          <i class="bi bi-calendar"></i>
          Inicio: {{ \Carbon\Carbon::parse($proyectoEstudiante->proyecto->fecha_inicio)->translatedFormat('d F Y') }}
        </p>
        <p class="card-text">
          <i class="bi bi-calendar-event"></i>
          Fin: {{ \Carbon\Carbon::parse($proyectoEstudiante->proyecto->fecha_fin)->translatedFormat('d F Y') }}
        </p>

        <p class="card-text"><i class="bi bi-geo-alt-fill"></i>{{ $proyectoEstudiante->proyecto->lugar }}</p>
        <p class="card-text"><i class="bi bi-person-fill"></i>Tutor: {{ $proyectoEstudiante->proyecto->tutorr ? $proyectoEstudiante->proyecto->tutorr->name : 'sin asignar' }}</p>
        <button class="btn-verde btn m-3">{{ $proyectoEstudiante->proyecto->estadoos->nombre_estado }}</button>
        <a href="{{route('estudiante.actualizarHorasView')}}">Actualizar horas</a>
      </div>
    </div>
  </div>
</div>

<!-- Historial de Actualizaciones -->
<div class="container containerhistorial mt-4">
  <div class="card shadow-m">
    <div class="card-body">
      <h2>Historial de actualizaciones</h2>
      <div class="table-responsive">
        <table class="table table-borderless">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Horas Aceptadas</th>
            </tr>
          </thead>
          <tbody>
            @if ($historial->isEmpty())
              <tr>
                <td colspan="2" class="text-center">No hay registros en el historial para este proyecto.</td>
              </tr>
            @else
              @foreach ($historial as $registro)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($registro->created_at)->format('d \d\e F \d\e Y') }}</td>
                  <td>{{ $registro->horas_aceptadas }} horas</td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <p class="text-center text-muted opacity-50">Registro de horas trabajadas</p>
  </div>
</div>

@endsection
