@extends('layouts.appE')

@section('title', 'Dashboard - Horas Sociales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-disponibleE.css') }}">
@endsection

@section('content')

<div class="container-fluid py-3 encabezado">
    <div class="container">
        <h2 class="titulo-encabezado">Proyectos disponibles</h2>
    </div>
</div>

<div class="container py-1 contenedor-card">
    <div class="bg-white shadow tarjeta-contenido">
        <div class="card-body">
            <h3 class="titulo-proyecto">Gestor de TI</h3>
            <p class="descripcion">
                <strong>Descripción:</strong> Este proyecto busca desarrollar las competencias tecnológicas y de gestión de TI en comunidades e instituciones educativas con acceso limitado a recursos tecnológicos. A través de la colaboración de estudiantes de tecnología, se pretende optimizar y digitalizar procesos de gestión, además de brindar soporte en infraestructura de TI y en el uso de herramientas informáticas. El proyecto será una oportunidad de aprendizaje y aplicación de conocimientos prácticos para los estudiantes, a la vez que brinda un servicio valioso a la comunidad.
            </p>
            <div class="detalles-proyecto">
                <p><strong>Horas requeridas:</strong> 500 horas</p>
                <p><strong>Ubicación:</strong> UES-FMO</p>
                <p><strong>Sección Departamento:</strong> Sistemas Informáticos</p>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button class="btn btn-enviar me-2">Enviar solicitud</button>
                <button class="btn btn-pdf">Generar PDF</button>
            </div>
        </div>
    </div>
</div>

@endsection