@extends('layouts.appE')

@section('title', 'Documentos para horas sociales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/documentos-sociales.css') }}">
@endsection

@section('content')

<div class="container pt-3 pb-5">
    <h2 class="titulo-documentos text-center mb-4">Documentos para horas sociales</h2>
    <p class="descripcion-documentos text-center mb-5">Descarga los documentos necesarios para cada etapa de tu servicio social</p>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Modelo de Carta a la Institución</h5>
                    <p class="descripcion-corta">Plantilla de carta para la institución que recibirá el estudiante</p>
                    <a href="{{ route('descargar', ['filename' => 'MODELO DE CARTA A LA INSTITUCION QUE SOLICITA ESTUDIANTES EN SERVICIO SOCIAL.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Hoja de Inscripción</h5>
                    <p class="descripcion-corta">Formulario inicial para la inscripción en el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'FORMULARIO N1 HOJA DE INSCRIPCION PARA SERVICIO SOCIAL.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Carta Asignación de Tutor</h5>
                    <p class="descripcion-corta">Documento oficial de asignación del tutor para el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'CARTA ASIGNACION DE TUTOR.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Control de Asesorías en servicio social</h5>
                    <p class="descripcion-corta">Registro de las asesorías recibidas durante el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Control de Asesorías a estudiantes en Servicio Social.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Constancia Aprobación del Plan de Trabajo</h5>
                    <p class="descripcion-corta">Documento de la aprobación del plan de trabajo para el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Constancia de aprobación del Plan de Trabajo del Servicio Social.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Informe del 50% del Servicio Social</h5>
                    <p class="descripcion-corta">Plantilla para el informe de avance del 50% del servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Informe del 50% del Servicio Social.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Informe del 100% del Servicio Social</h5>
                    <p class="descripcion-corta">Plantilla para el informe de avance del 100% del servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Informe del 100% del Servicio Social.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Ficha de Supervisión y Evaluación del Servicio Social</h5>
                    <p class="descripcion-corta">Documento para la supervisión y evaluación del servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Ficha de supervisión y evaluación del Servicio Social.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Constancia del Docente Tutor de Servicio Social</h5>
                    <p class="descripcion-corta">Documento del tutor que certifica la realización del servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Constancia del Docente Tutor de Servicio Social.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Constancia de Finalización del Servicio Social</h5>
                    <p class="descripcion-corta">Documento que certifica la finalización del servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Constancia de Finalización del Servicio Social.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Modelo de Certificación</h5>
                    <p class="descripcion-corta">Ejemplo de certificación para el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Modelo de Certificación.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Constancia de la Institución</h5>
                    <p class="descripcion-corta">Certificado emitido por la institución donde se realizó el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Constancia de la Institución.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Ficha de Desempeño del Estudiante en Servicio Social</h5>
                    <p class="descripcion-corta">Evaluación del desempeño del estudiante durante el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Ficha de desempeño del estudiante en Servicio Social.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Control de Asistencia</h5>
                    <p class="descripcion-corta">Formulario para registrar la asistencia durante el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Control de Asistencia.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Formulario 3-5 Para El Ministerio</h5>
                    <p class="descripcion-corta">Formulario requerido por el Ministerio para el servicio social</p>
                    <a href="{{ route('descargar', ['filename' => 'Formulario Nº 8 Formulario 3-5 Para El MINED.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Ejemplo de Documentación para el Informe Final</h5>
                    <p class="descripcion-corta">Guía y ejemplos para la elaboración del informe final</p>
                    <a href="{{ route('descargar', ['filename' => 'EJEMPLO DE DOCUMENTACION PARA EL PROYECTO DE SERVICIO SOCIAL.docx']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="titulo-documento">Manual de Proyección Social</h5>
                    <p class="descripcion-corta">Guía completa sobre el proceso de proyección social</p>
                    <a href="{{ route('descargar', ['filename' => 'Manual de proyeccion social.doc']) }}" class="btn btn-descargar"><i class="bi bi-download"></i> Descargar</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
