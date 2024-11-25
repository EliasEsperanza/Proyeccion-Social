@extends('layouts.appE')
@section('title', 'Documentos de Trámites Generales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style_process.css') }}">
@endsection

@section('content')
<div class="container pt-3 pb-5">
    <h2 class="titulo-documentos text-center mb-4">Documentos de Trámites Generales</h2>
    <p class="descripcion-documentos text-center mb-5">Descarga los documentos necesarios para realizar trámites generales</p>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Ampliación de tiempo (Proyecto)</h5>
                    <p class="descripcion-corta">Plantilla de carta para ampliación de tiempo del proyecto</p>
                    <a href="{{ route('descargar', ['filename' => 'Carta de ampliacion de tiempo.docx']) }}" class="btn btn-descargar">
                        <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Eliminación de estudiante del proyecto (Jefes)</h5>
                    <p class="descripcion-corta">Formato para eliminar a un estudiante del proyecto</p>
                    <a href="{{ route('descargar', ['filename' => 'Carta de Eliminacion de Estudiante del Proyecto (grupo).docx']) }}" class="btn btn-descargar">
                        <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Eliminación de estudiante del proyecto (Estudiante)</h5>
                    <p class="descripcion-corta">Formato para eliminar a un estudiante del proyecto</p>
                    <a href="{{ route('descargar', ['filename' => 'Carta de Eliminacion de un estudiante (estudiante).docx']) }}" class="btn btn-descargar">
                        <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Eliminación de proyecto</h5>
                    <p class="descripcion-corta">Formato para eliminación de proyecto</p>
                    <a href="{{ route('descargar', ['filename' => 'Carta de eliminacion de proyecto.docx']) }}" class="btn btn-descargar">
                        <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>
        </div>

        <div class="col ultimo-card">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Solicitud de prórroga a jefes de UPS</h5>
                    <p class="descripcion-corta">Se entrega antes de vencer los 3 meses de la entrega</p>
                    <a href="{{ route('descargar', ['filename' => 'Carta de Prorroga a Jefe de Unidad.docx']) }}" class="btn btn-descargar">
                        <i class="bi bi-download"></i> Descargar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection