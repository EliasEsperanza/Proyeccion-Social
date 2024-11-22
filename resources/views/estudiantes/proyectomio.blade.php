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

        <h2>Gestor de TI</h2>

        <!-- Progress bar -->
        <div class="my-4">
            <div class="d-flex justify-content-between ">
            <p class="card-text">Progreso del Proyecto</p>
            <p>15 de 500 horas</p>
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
            <p class="card-text"><i class="bi bi-calendar"></i>Inicio: 29 de febrero del 2024</p>
            <p class="card-text"><i class="bi bi-calendar-event"></i>Fin: 30 de septiembre del 2024</p>
            <p class="card-text"><i class="bi bi-geo-alt-fill"></i></i>Universidad de El Salvador</p>
            <p class="card-text"><i class="bi bi-person-fill"></i></i>Tutor: Ing. Diego Herrera</p>
            <button class="btn-verde btn m-3">Anteproyecto</button>
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

