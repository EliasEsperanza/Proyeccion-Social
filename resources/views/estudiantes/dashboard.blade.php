@extends('layouts.appE')

@section('title', 'Dashboard - Horas Sociales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/estudianteprincipal.css') }}">
<link rel="stylesheet" href="{{ asset('css/deshboard-title.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endsection

@section('content')

@if (session()->has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card mx-auto mb-4 card-med">
    <div class="card-body">
        <h2 class="card-title text-start fw-bold">Proceso de Horas Sociales</h2>
        <p class="card-text text-muted text-start">Seguimiento paso a paso de tu proceso</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-center">
                <span class="badge rounded-circle me-3 d-flex align-items-center justify-content-center circulo-paso" style="width: 30px; height: 30px;">1</span>
                Nota de la institución donde se desarrollarán las horas sociales
            </li>
            <li class="list-group-item d-flex align-items-center">
                <span class="badge rounded-circle me-3 d-flex align-items-center justify-content-center circulo-paso" style="width: 30px; height: 30px;">2</span>
                Carta No. 1 Asignación de tutor de servicio social
            </li>
            <li class="list-group-item d-flex align-items-center">
                <span class="badge rounded-circle me-3 d-flex align-items-center justify-content-center circulo-paso" style="width: 30px; height: 30px;">3</span>
                Formulario No. 1 Hoja de inscripción para realizar servicio social
            </li>
            <li class="list-group-item d-flex align-items-center">
                <span class="badge rounded-circle me-3 d-flex align-items-center justify-content-center circulo-paso" style="width: 30px; height: 30px;">4</span>
                Constancia de la administración académica del 60% de la carrera
            </li>
            <li class="list-group-item d-flex align-items-center">
                <span class="badge rounded-circle me-3 d-flex align-items-center justify-content-center circulo-paso" style="width: 30px; height: 30px;">5</span>
                Carta No. 2 Constancia de aprobación del plan de trabajo del servicio social
            </li>
        </ul>
    </div>
</div>

<div class="contenedor-carrusel ">
    <h2 class="titulo-proyectos mb-4">Proyectos disponibles</h2>
    @if ($proyectos->isEmpty())
    <p class="text-muted text-center">No hay proyectos disponibles en este momento.</p>
    @endif
    <div class="d-flex align-items-center justify-content-center ">
        <button class="btn boton-carrusel" id="btnIzquierda">
            <span class="flecha-carrusel"><i class="bi bi-arrow-left"></i></span>
        </button>
        <div class="carrusel carru" id="contenedorCarrusel">
            @foreach ($proyectos as $proyecto)
            <div class="tarjeta-proyecto carru">
                <h3 class="card-title c-titulo">{{ $proyecto->nombre_proyecto }}</h3>
                <br>
                <p class="card-text">Descripción:</p>
              <p class="card-text descripcion">{{ \Illuminate\Support\Str::limit($proyecto->descripcion_proyecto, 40, '...') }}</p>
                <p class="card-text"><strong>Horas requeridas:</strong> {{ $proyecto->horas_requeridas }}</p>
                <div class="estado-boton">
                    <a href="{{ route('proyecto.ver', $proyecto->id_proyecto) }}" class="ver-mas">VER MÁS</a>
                    <span class="badge {{ $proyecto->estado == 1 ? 'estado-disponible' : 'estado-no-disponible' }}">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $proyecto->estado == 1 ? 'Disponible' : 'No Disponible' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        <button class="btn boton-carrusel" id="btnDerecha">
            <span class="flecha-carrusel"><i class="bi bi-arrow-right"></i></span>
        </button>
    </div>
</div>


<div class="card mt-5 mx-auto card-med mb-4">
    <div class="card-body c-b">
        <h2 class="titulo-documentos">Documentos</h2>
        <p class="descripcion-documentos text-start">
            Descarga los documentos necesarios para tu proceso
        </p>
        <ul class="lista-documentos">
            <li class="item-documento">
                <a href="{{ route('descargar', ['filename' => 'MODELO DE CARTA A LA INSTITUCION QUE SOLICITA ESTUDIANTES EN SERVICIO SOCIAL.docx']) }}" class="enlace-documento">
                    <span class="icono-documento">&#128196;</span>
                    <span class="texto-documento text-start">MODELO DE CARTA A LA INSTITUCION QUE SOLICITA ESTUDIANTES EN SERVICIO SOCIAL</span>
                </a>
            </li>

            <li class="item-documento">
                <a href="{{ route('descargar', ['filename' => 'FORMULARIO N1 HOJA DE INSCRIPCION PARA SERVICIO SOCIAL.docx'] ) }}" class="enlace-documento">
                    <span class="icono-documento">&#128196;</span>
                    <span class="texto-documento text-start">FORMULARIO N1 HOJA DE INSCRIPCION PARA SERVICIO SOCIAL</span>
                </a>
            </li>

        </ul>
        <a href="{{ route('documentos_horas_sociales') }}" class="ver-mas-documentos">VER MÁS</a>
    </div>

    <script src="{{ asset('js/estudianteprincipal.js') }}"></script>
    @endsection