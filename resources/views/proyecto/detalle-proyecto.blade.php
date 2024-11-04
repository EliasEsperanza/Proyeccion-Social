@extends('layouts.app')

@section('title', 'Detalle del Proyecto')

@section('content')
<div class="container-fluid d-flex justify-content-center mt-4">
    <div class="col-md-9 d-flex justify-content-center">
        <div class="card p-4 detail-card">
            <h2 class="text-center">Gestor de TI</h2>
            
            <h3>Descripción:</h3>
            <p>Este proyecto busca desarrollar las competencias tecnológicas y de gestión de TI en comunidades e instituciones educativas con acceso limitado a recursos tecnológicos. A través de la colaboración de estudiantes de tecnología, se pretende optimizar y digitalizar procesos de gestión, además de brindar soporte en infraestructura de TI y en el uso de herramientas informáticas. El proyecto será una oportunidad de aprendizaje y aplicación de conocimientos prácticos para los estudiantes, a la vez que brinda un servicio valioso a la comunidad.</p>
            
            <h4>Horas requeridas:</h4>
            <p>500 horas</p>
            
            <h4>Ubicación:</h4>
            <p>UES-FMO</p>
            
            <h4>Sección Departamento:</h4>
            <p>Sistemas Informáticos</p>
            
            <div class="button-container">
                <a href="{{ route('proyecto-disponible') }}" class="btn btn-secondary btn-return">Volver</a>
                <a href="#" class="btn btn-danger btn-pdf">Generar PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/detalle.css') }}" rel="stylesheet">
@endpush
