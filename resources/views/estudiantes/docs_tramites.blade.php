@extends('layouts.appE')
@section('title', 'Documentos de Trámites Generales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style_process.css') }}">
@endsection

@section('content')
<div class="main-container">
    <h1 class="main-title">Documentos de Tramites generales</h1>
    <p class="subtitle">Descarga los documentos necesarios para realizar tramites generales</p>

    <div class="documents-grid">
        <div class="document-card">
            <h2 class="document-title">Ampliacion de tiempo (Proyecto)</h2>
            <p class="document-description">Plantilla de carta para ampliación de tiempo del proyecto</p>
            <a href="{{ route('descargar', ['filename' => 'Carta de ampliacion de tiempo.docx']) }}" class="download-button">
                <i class="bi bi-download download-icon"></i>
                Descargar
            </a>
        </div>

        <div class="document-card">
            <h2 class="document-title">Eliminacion de estudiante del proyecto</h2>
            <p class="document-description">Formato para eliminar a un estudiante del proyecto (jefes)</p>
            <a href="{{ route('descargar', ['filename' => 'Carta de Eliminacion de Estudiante del Proyecto (grupo).docx']) }}" class="download-button">
                <i class="bi bi-download download-icon"></i>
                Descargar
            </a>
        </div>

        <div class="document-card">
            <h2 class="document-title">Eliminacion de estudiante del proyecto</h2>
            <p class="document-description">Formato para eliminar a un estudiante del proyecto (estudiante)</p>
            <a href="{{ route('descargar', ['filename' => 'Carta de Eliminacion de un estudiante (estudiante).docx']) }}" class="download-button">
                <i class="bi bi-download download-icon"></i>
                Descargar
            </a>
        </div>

        <div class="document-card">
            <h2 class="document-title">Eliminacion de proyecto</h2>
            <p class="document-description">Formato para eliminación de proyecto</p>
            <a href="{{ route('descargar', ['filename' => 'Carta de eliminacion de proyecto.docx']) }}" class="download-button">
                <i class="bi bi-download download-icon"></i>
                Descargar
            </a>
        </div>

        <div class="document-card">
            <h2 class="document-title">Solicitud de prorroga a jefes de UPS</h2>
            <p class="document-description">Se entrega antes de vencer los 3 meses de la entrega</p>
            <a href="{{ route('descargar', ['filename' => 'Carta de Prorroga a Jefe de Unidad.docx']) }}" class="download-button">
                <i class="bi bi-download download-icon"></i>
                Descargar
            </a>
        </div>
    </div>
</div>
@endsection