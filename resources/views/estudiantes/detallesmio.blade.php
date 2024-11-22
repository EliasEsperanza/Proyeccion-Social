@extends('layouts.appE')

@section('title', 'Detalles del Proyecto')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/detallesProyecMio.css') }}">

@endsection

@section('content')

<div class="container mt-1">
<h1 class="card-title mb-4 text-rigth">Detalles del Proyecto</h1>
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
          <h3>30% Completado</h3>
        </div>
        
        <!-- Project details -->
        <div class="mr-4">
            <p class="card-text"><i class="bi bi-calendar"></i>Inicio: 29 de febrero del 2024</p>
            <p class="card-text"><i class="bi bi-calendar-event"></i>Fin: 30 de septiembre del 2024</p>
            <p class="card-text"><i class="bi bi-geo-alt-fill"></i></i>Universidad de El Salvador</p>
            <p class="card-text"><i class="bi bi-person-fill"></i></i>Tutor: Ing. Diego Herrera</p>
            <button class="btn-verde btn m-3">Anteproyecto</button>
        </div>
      </div>
    </div>
</div>

<div class="container containerhistorial mt-4">
    <div class="card shadow-m">
      <div class="card-body">
        <h2>Historial de actualizaciones</h2>
        <div class="table-responsive">
          <table class="table table-borderless">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Horas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>4 de marzo de 2024</td>
                <td>5</td>
              </tr>
              <tr>
                <td>11 de marzo de 2024</td>
                <td>7</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <p class="text-center text-muted opacity-50">Registro de horas trabajadas</p>
    </div>
</div>


@endsection