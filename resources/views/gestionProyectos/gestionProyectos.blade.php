@extends('layouts.app') 

@section('title', 'Gestión de Proyectos')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/gestionProyecto.css') }}">

@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container ">
    
    <div class="container">
        <h1 class="mb-4">Gestión de Proyectos</h1>
    
        <div class="card w-100">
            <div class="card-body">
            <!-- Sección de Estudiantes -->
            <div class="mb-3">
                <label class="form-label">Estudiantes</label>
                
                <!-- Formulario para agregar estudiantes -->
                <form action="" method="POST" class="d-flex mb-3" id="formAsignarEstudiante">
                    @csrf
                    <input type="hidden" id="proyecto_id" name="proyecto_id" value="">
                    <select class="form-select" id="idEstudiante" name="idEstudiante" >
                            @foreach ($estudiantes as $estudiante)
                                    <option value="{{ $estudiante->id_estudiante }}">
                                        {{ $estudiante->usuario->name }}
                                    </option>
                            @endforeach
                    </select>
                    <button type="submit" class="btn btn-light btn-sm p-2 px-3">
                        <i class="bi bi-plus"></i>
                    </button>
                </form>
            </div>
            <form action="" method="POST">
                    @csrf
            <div class="mb-3">
                <label for="proyectosDisponibles" class="form-label">Proyectos Disponibles</label>
                <select class="form-select" id="proyectosDisponibles" name="proyecto_id">
                    <option selected disabled>Seleccione un proyecto</option>
                    @foreach($ListProyecto as $proyecto)
                    <option value="{{$proyecto->id_proyecto}}">{{$proyecto->nombre_proyecto}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Sección o Departamento</label>
                <div class="input-group mb-3">
                    <select class="form-control" id="seccion_id" name="seccion_id">
                        <option selected disabled>Seleccione una sección</option>
                        @foreach($secciones as $seccion)
                        <option value="{{$seccion->id_seccion}}">{{$seccion->nombre_seccion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Campo oculto para almacenar estudiantes seleccionados -->
            <input type="hidden" id="estudiantesSeleccionados" name="estudiantes">

            <ul id="listaEstudiantes" class="list-unstyled"></ul>

            <div class="mb-3">
                <label for="tutor" class="form-label">Tutor</label>
                <select class="form-control" id="tutor" name="tutor_id">
                    <option selected disabled>Seleccione un tutor</option>
                    @foreach($tutores as $tutor)
                    <option value="{{$tutor->id_usuario}}">{{$tutor->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" readonly>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fechaFin" class="form-label">Fecha de Finalización</label>
                    <input type="date" class="form-control" id="fechaFin" name="fecha_fin" readonly>
                </div>
            </div>

            <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" id="estado" name="estado_id">
                        <option selected disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-gestion fw-bold">Crear Proyecto</button>
        </form> 

            </div>
        </div>
    </div>

<div id="tutores-data" data-tutores='@json($tutores)'></div>
<div id="estudiantes-data" data-estudiantes='@json($estudiantes)'></div>
<script src="{{ asset('js/filtrarTutor.js') }}"></script>
<script src="{{ asset('js/filtrarEstudiantes.js') }}"></script>
<script src="{{ asset('js/gestionProyecto.js') }}"></script>
<!-- script para pasar el id del proyecto seleccionado -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const selectProyecto = document.getElementById('proyectosDisponibles');
    const formulario = document.getElementById('formAsignarEstudiante');

    selectProyecto.addEventListener('change', function () {
        const proyectoId = this.value; // Obtener el ID del proyecto seleccionado

        if (proyectoId) {
            // Actualizar dinámicamente el atributo 'action' del formulario
            formulario.action = `/proyectos/${proyectoId}/asignar-estudiantes`;
        } else {
            // Si no hay proyecto seleccionado, vaciar el action
            formulario.action = '';
        }
    });
});
</script>

@endsection