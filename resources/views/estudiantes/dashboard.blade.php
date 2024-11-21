@extends('layouts.appE')

@section('title', 'Dashboard - Horas Sociales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/estudianteprincipal.css') }}">
@endsection

@section('content')


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
    <div class="d-flex align-items-center justify-content-center ">
        <button class="btn boton-carrusel" id="btnIzquierda">
            <span class="flecha-carrusel"><i class="bi bi-arrow-left"></i></span>
        </button>
        <div class="carrusel carru" id="contenedorCarrusel">
            <div class="tarjeta-proyecto carru">
                <h3 class="card-title">Gestor de TI</h3>
                <br>
                <p class="card-text">
                    Descripción:
                </p>
                <p class="card-text">
                Este proyecto busca desarrollar las competencias tecnológicas y de gestión de TI.
                </p>
                <p class="card-text">
                <strong>Horas requeridas:</strong> 500
                </p>
                <div class="estado-boton">
                    <span class="badge estado-disponible">Disponible</span>
                    <a href="#" class="ver-mas">VER MÁS</a>
                </div>
            </div>
            <div class="tarjeta-proyecto">
                <h3 class="card-title">Gestor de TI</h3>
                <br>
                <p class="card-text">Descripción:</p>
                <p class="card-text">Este proyecto busca desarrollar las competencias tecnológicas y de gestión de TI.</p>
                <p class="card-text"><strong>Horas requeridas:</strong> 500</p>
                <div class="estado-boton">
                    <span class="badge estado-no-disponible">No disponible</span>
                    <a href="#" class="ver-mas">VER MÁS</a>
                </div>
            </div>
            <div class="tarjeta-proyecto">
                <h3 class="card-title">Gestor de Infraestructura</h3>
                <br>
                <p class="card-text">Descripción:</p>
                <p class="card-text">Propuesta para mejorar la infraestructura tecnológica.</p>
                <p class="card-text"><strong>Horas requeridas:</strong> 400</p>
                <div class="estado-boton">
                    <span class="badge estado-disponible">Disponible</span>
                    <a href="#" class="ver-mas">VER MÁS</a>
                </div>
            </div>
            <div class="tarjeta-proyecto">
                <h3 class="card-title">Desarrollador Web</h3>
                <br>
                <p class="card-text">Descripción:</p>
                <p class="card-text">Crear páginas web dinámicas con tecnologías modernas.</p>
                <p class="card-text"><strong>Horas requeridas:</strong> 350</p>
                <div class="estado-boton">
                    <span class="badge estado-no-disponible">No disponible</span>
                    <a href="#" class="ver-mas">VER MÁS</a>
                </div>
            </div>
        </div>
        <button class="btn boton-carrusel" id="btnDerecha">
            <span class="flecha-carrusel"><i class="bi bi-arrow-right"></i></span>
        </button>
    </div>
</div>

<div class="card mt-5 mx-auto card-med mb-4">
    <div class="card-body">
        <h2 class="titulo-documentos">Documentos</h2>
    <p class="descripcion-documentos text-start">
        Descarga los documentos necesarios para tu proceso
    </p>
    <ul class="lista-documentos">
        <li class="item-documento">
            <a href="documentos/formato_nota_institucion.pdf" download="Formato_Nota_Institucion.pdf" class="enlace-documento">
                <span class="icono-documento">&#128196;</span>
                <span class="texto-documento text-start">FORMATO NOTA DE LA INSTITUCIÓN</span>
            </a>
        </li>
        <li class="item-documento">
            <a href="documentos/formato_inscripcion.pdf" download="Formato_Inscripcion.pdf" class="enlace-documento">
                <span class="icono-documento">&#128196;</span>
                <span class="texto-documento text-start">FORMATO PARA LA INSCRIPCIÓN</span>
            </a>
        </li>
        <li class="item-documento">
            <a href="documentos/formato_presentacion_memoria.pdf" download="Formato_Presentacion_Memoria.pdf" class="enlace-documento">
                <span class="icono-documento">&#128196;</span>
                <span class="texto-documento text-start">FORMATO PARA PRESENTACIÓN DE MEMORIA</span>
            </a>
        </li>
    </ul>
    <a href="#" class="ver-mas-documentos">VER MÁS</a>
    </div>
</div>

<script src="{{ asset('js/estudianteprincipal.js') }}"></script>
@endsection