@extends('layouts.appE')
@section('title', 'Proceso de Horas Sociales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style_process.css') }}">
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="text-center text-dark mb-3">Proceso de Horas Sociales</h1>
    <p class="text-center text-muted mb-5">Sigue estos pasos interactivos para completar tu servicio social de manera efectiva.</p>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="process-card text-center">
                <div class="icon-wrapper mb-3">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <h2 class="step-title">1. Inscripción</h2>
                <p class="step-description">Inicia el proceso de inscripción para el servicio social.</p>
                <ul class="step-list">
                    <li>Presentarse en la unidad de proyección social para abrir expediente.</li>
                    <li>Solicitar y llenar el Formulario de Hoja de Inscripción (Formulario N°1).</li>
                    <li>Entregar el formulario al coordinador de la subunidad.</li>
                </ul>
                <a href="{{ route('descargar', ['filename' => 'FORMULARIO N1 HOJA DE INSCRIPCION PARA SERVICIO SOCIAL.docx']) }}" class="btn btn-danger">
                    <i class="bi bi-download me-2"></i>Descargar Formulario
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="process-card text-center">
                <div class="icon-wrapper mb-3">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <h2 class="step-title">2. Autorización y Planificación</h2>
                <p class="step-description">Obtén la autorización y planifica tu servicio social.</p>
                <ul class="step-list">
                    <li>Recibir carta de autorización para iniciar el servicio social.</li>
                    <li>Consultar las opciones de servicio social disponibles.</li>
                    <li>Elaborar un plan de trabajo con el tutor asignado.</li>
                    <li>Entregar el plan al coordinador de la subunidad.</li>
                </ul>
                <a href="{{ route('descargar', ['filename' => 'Constancia de aprobación del Plan de Trabajo del Servicio Social.docx']) }}" class="btn btn-danger">
                    <i class="bi bi-download me-2"></i>Descargar Plan
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="process-card text-center">
                <div class="icon-wrapper mb-3">
                    <i class="bi bi-briefcase"></i>
                </div>
                <h2 class="step-title">3. Ejecución del Servicio</h2>
                <p class="step-description">Realiza tu servicio social y lleva un registro de tus actividades.</p>
                <ul class="step-list">
                    <li>Acudir a la entidad donde realizarás el servicio social.</li>
                    <li>Llevar control de asistencia (Formulario N°2).</li>
                    <li>Realizar el servicio social entre tres y dieciocho meses.</li>
                    <li>Entregar un informe de avance del 50% (Formulario N°3).</li>
                </ul>
                <a href="{{ route('descargar', ['filename' => 'Control de Asistencia.docx']) }}" class="btn btn-danger">
                    <i class="bi bi-download me-2"></i>Descargar Control
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="process-card text-center">
                <div class="icon-wrapper mb-3">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h2 class="step-title">4. Informe Final</h2>
                <p class="step-description">Prepara y presenta tu informe final (memoria de labores).</p>
                <ul class="step-list">
                    <li>Elaborar la memoria de labores según el formato establecido.</li>
                    <li>Entregar la memoria en formato digital PDF.</li>
                    <li>Solicitar al tutor la evaluación del trabajo realizado (Formulario N°6).</li>
                </ul>
                <a href="{{ route('descargar', ['filename' => 'EJEMPLO DE DOCUMENTACION PARA EL PROYECTO DE SERVICIO SOCIAL.docx']) }}" class="btn btn-danger">
                    <i class="bi bi-download me-2"></i>Descargar Guía
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
