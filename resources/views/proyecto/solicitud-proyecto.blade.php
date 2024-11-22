@extends('layouts.app')

@section('title', 'Solicitud de proyectos')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/solicitud-proyecto.css') }}">
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@endsection

@section('content')
<h1>Solicitudes de proyectos</h1>
    <div class="card">
        <div class="title">Gestion de TI</div>
        <div class="subtitle">Kevin Nathanael</div>
        <div class="info-item time">500 horas</div>
        <div class="info-item location">Universidad de el Salvador</div>
        <a class="ver-mas" href="{{ route('gestor_de_TI') }}" onclick="establecerActivo(this)">Ver más</a>
        <div class="actions">
            <button class="button accept">Aceptar</button>
            <button class="button reject">Rechazar</button>
        </div>
    </div>

@endsection