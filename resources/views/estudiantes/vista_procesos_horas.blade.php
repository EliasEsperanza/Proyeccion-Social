@extends('layouts.appE')
@section('title', 'Proceso de Horas Sociales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style_process.css') }}">

@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Proceso de Horas Sociales</h1>
    <p class="step-description">Sigue estos pasos para completar tu servicio social</p>

    <div class="row">
        <div class="col-12">
            <!-- Paso 1 -->
            <div class="process-card">
                <h2 class="step-title">
                    <span class="step-number">1</span>
                    Inscripción
                </h2>
                <p class="step-description">Inicia el proceso de inscripción para el servicio social</p>
                <ul class="step-list">
                    <li>Presentarse en la unidad de proyección social para abrir expediente.</li>
                    <li>Solicitar y llenar el Formulario de Hoja de Inscripción (Formulario N°1).</li>
                    <li>Entregar el formulario al coordinador de la subunidad de Proyección Social.</li>
                </ul>
                <a href="{{ route('descargar', ['filename' => 'Formato_de_Inscripcion.docx']) }}" class="download-btn">
                    <i class="bi bi-download me-2"></i>
                    Descargar formulario-inscripcion.pdf
                </a>
            </div>

            <!-- Paso 2 -->
            <div class="process-card">
                <h2 class="step-title">
                    <span class="step-number">2</span>
                    Autorización y Planificación
                </h2>
                <p class="step-description">Obtén la autorización y planifica tu servicio social</p>
                <ul class="step-list">
                    <li>Recibir carta de autorización para iniciar el servicio social.</li>
                    <li>Consultar las opciones de servicio social disponibles.</li>
                    <li>Elaborar un plan de trabajo con ayuda del tutor asignado.</li>
                    <li>Entregar el plan de trabajo al coordinador de la sub-unidad.</li>
                </ul>
                <a href="#" class="download-btn">
                    <i class="bi bi-download me-2"></i>
                    Descargar plan-trabajo.pdf
                </a>
            </div>

            <!-- Paso 3 -->
            <div class="process-card">
                <h2 class="step-title">
                    <span class="step-number">3</span>
                    Ejecución del Servicio Social
                </h2>
                <p class="step-description">Realiza tu servicio social y lleva un registro de tus actividades</p>
                <ul class="step-list">
                    <li>Acudir a la entidad donde realizarás el servicio social.</li>
                    <li>Llevar control de asistencia (Formulario N°2).</li>
                    <li>Realizar el servicio social entre tres y dieciocho meses calendario.</li>
                    <li>Entregar un informe de avance del 50% (Formulario N°3).</li>
                </ul>
                <a href="#" class="download-btn">
                    <i class="bi bi-download me-2"></i>
                    Descargar control-asistencia.pdf
                </a>
            </div>

            <!-- Paso 4 -->
            <div class="process-card">
                <h2 class="step-title">
                    <span class="step-number">4</span>
                    Informe Final
                </h2>
                <p class="step-description">Prepara y presenta tu informe final (memoria de labores)</p>
                <ul class="step-list">
                    <li>Elaborar la memoria de labores según el formato establecido.</li>
                    <li>Entregar la memoria en formato digital PDF.</li>
                    <li>Solicitar al tutor la evaluación del trabajo realizado (Formulario N°6).</li>
                </ul>
                <a href="#" class="download-btn">
                    <i class="bi bi-download me-2"></i>
                    Descargar guia-memoria-labores.pdf
                </a>
            </div>
        </div>
    </div>
</div>
@endsection