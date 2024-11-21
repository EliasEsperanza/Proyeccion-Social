@extends('layouts.app')

@section('title', 'Gestor de TI')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="{{ asset('css/gestor-de-TI.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@endsection

@section('content')
    <div class="job-card">
            <h1>Gestor de TI</h1>

            <div class="section">
                <div class="section-title"><i class="fas fa-file-alt"></i> Descripción:</div>
                <div class="section-content">
                    Este proyecto busca desarrollar las competencias tecnológicas y de gestión de TI en comunidades e instituciones educativas con acceso limitado a recursos tecnológicos. A través de la colaboración de estudiantes de tecnología, se construirá estrategias y adaptable procesos de gestión, además de brindar soporte en infraestructura de TI y en el uso de herramientas informáticas. El proyecto será una oportunidad de aprendizaje y aplicación de conocimientos prácticos para los estudiantes, a la vez que brinda un servicio valioso a la comunidad.
                </div>
            </div>

            <div class="section">
                <div class="section-title"><i class="fas fa-clock"></i> Horas requeridas:</div>
                <div class="section-content">500 horas</div>
            </div>

            <div class="section">
                <div class="section-title"><i class="fas fa-map-marker-alt"></i> Ubicación:</div>
                <div class="section-content">UIS-PMG</div>
            </div>

            <div class="section">
                <div class="section-title"><i class="fas fa-building"></i> Sección Departamental:</div>
                <div class="section-content">Sistemas Informáticos</div>
            </div>

            <div class="button-group">
                <button class="btn btn-accept">Aceptar</button>
                <button class="btn btn-reject">Rechazar</button>
            </div>
        </div>

@endsection