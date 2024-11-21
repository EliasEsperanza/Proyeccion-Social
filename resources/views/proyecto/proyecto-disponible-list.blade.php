@extends('layouts.app')

@section('title', 'Lista de proyectos disponibles')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-disponible-list.css') }}">
<link rel="stylesheet" href="{{ asset('css/gestor-de-TI.css') }}">
<link rel="stylesheet" href="{{ asset('css/gestor-de-TI.css') }}">
<link rel="stylesheet" href="{{ asset('css/solicitud-proyecto.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


@section('content')
    <div class="project-card">
        <h3>Gestión de TI</h3>
        <div class="info-item time">500 horas</div>
        <div class="info-item location">Universidad de el Salvador</div>
        <div> <a href="#" class="ver-mas">ver mas </a></div>
        <button>Enviar solicitud</button>
    </div>

    <div class="project-card">
        <h3>Gestión de TI</h3>
        <div class="info-item time">500 horas</div>
        <div class="info-item location">Universidad de el Salvador</div>
        <div> <a href="#" class="ver-mas">ver mas </a></div>
        <button>Enviar solicitud</button>
    </div>

    <div class="project-card">
        <h3>Gestión de TI</h3>
        <div class="info-item time">500 horas</div>
        <div class="info-item location">Universidad de el Salvador</div>
        <div> <a href="#" class="ver-mas">ver mas </a></div>
        <button>Enviar solicitud</button>
    </div>
@endsection