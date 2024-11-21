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
        <div class="d-flex justify-content-between ">
          <p class="card-text">Progreso del Proyecto</p>
          <p>Completadas {{ $proyectoEstudiante->horas_sociales_completadas }}  de {{ $proyectoEstudiante->proyecto->horas_requeridas }} horas</p>
        </div>

        <div class="progress" style="height: 20px;">
          <div class="progress-bar" role="progressbar"
            style="width: 30%;"
            aria-valuenow="15"
            aria-valuemin="0"
            aria-valuemax="100">

          </div>
        </div>
      </div>

      <div class="mr-4">
        <p class="card-text"><i class="bi bi-calendar"></i>Inicio: {{ $proyectoEstudiante->proyecto->fecha_inicio }}</p>
        <p class="card-text"><i class="bi bi-calendar-event"></i>Fin: {{ $proyectoEstudiante->proyecto->fecha_fin }}</p>
        <p class="card-text"><i class="bi bi-geo-alt-fill"></i></i>{{ $proyectoEstudiante->proyecto->lugar }}</p>
        <p class="card-text"><i class="bi bi-person-fill"></i></i>Tutor: {{ $proyectoEstudiante->proyecto->tutorr->name }}</p>
        <button class="btn-verde btn m-3">{{ $proyectoEstudiante->proyecto->estadoos->nombre_estado }}</button>
      </div>

      <!-- Buttons -->
      <div class="d-flex justify-content-between p-3">
        <button class="btn-actualizar btn">Actualizar Horas</button>
        <a href="{{ route('detallesmio') }}" class="btn-detalles btn">Ver Detalles</a>
      </div>
    </div>
  </div>
</div>
@endsection