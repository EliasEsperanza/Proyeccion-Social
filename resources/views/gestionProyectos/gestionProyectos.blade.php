@extends('layouts.app')

@section('title', 'Gestión de Proyectos')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/gestionProyecto.css') }}">
<link rel="stylesheet" href="{{ asset('css/gestionProyecto.css') }}">
<link href="{{ asset('css/preloder.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="container ">


    <div class="container">
        <div id="preloader" class="loader-size">
            <div class="loader">
                <div class="face face1">
                    <div class="circle"></div>
                </div>
                <div class="face face2">
                    <div class="circle"></div>
                </div>
            </div>
        </div>

        <div id="preloader" class="loader" style="display: none;">
            <div class="face face1">
                <div class="circle">
                </div>
            </div>
            <div class="face face2">
                <div class="circle">
                </div>
            </div>
        </div>
        <h1 class="mb-4">Gestión de Proyectos</h1>

        <div class="card w-100">
            <div class="card-body">
                <form action="" method="" id="actualizarProyecto">
                    @csrf

                    <div class="mb-3">
                        <label for="proyectosDisponibles" class="form-label">Proyectos Disponibles</label>
                        <select class="form-select" id="nombre_proyecto" name="nombre_proyecto">
                            <option selected disabled>Seleccione un proyecto</option>
                            @foreach($proyectos as $proyecto)
                            <option value="{{$proyecto->id_proyecto}}">{{$proyecto->nombre_proyecto}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Sección o Departamento</label>
                        <div class="input-group mb-3">
                            <select name="seccion_id" class="form-select @error('departamento') is-invalid @enderror" id="seccion_id">
                            </select>
                        </div>
                    </div>


                    <!-- Sección de Estudiantes -->
                    <div class="mb-3">
                        <label class="form-label">Estudiantes</label>

                        <div class="d-flex">
                            <select class="form-select" id="idEstudiante" name="idEstudiante" disabled>
                                <option value='' disabled>Seleccionar un estudiante</option>
                                @foreach ($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id_estudiante }}">
                                    {{ $estudiante->usuario->name }}
                                </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-light btn-sm p-2 px-3" id="addStudentBtn">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>

                        <!-- Lista para mostrar los estudiantes seleccionados -->
                        <ul id="studentList" class="mt-3"></ul>

                        <!-- Lista de estudiantes asignados -->
                        <ul id="estudiantesList">
                        </ul>
                    </div>


                    <!-- Campo oculto para almacenar estudiantes seleccionados -->
                    <input type="hidden" id="estudiantesSeleccionados" name="estudiantes">

                    <ul id="listaEstudiantes" class="list-unstyled"></ul>

                    <div class="mb-3">
                        <label for="tutor" class="form-label">Tutor</label>
                        <select class="form-control" id="idTutor" name="idTutor" disabled>
                            <option selected disabled>Seleccione un tutor</option>
                            @foreach($tutores as $tutor)
                            <option value="{{$tutor->id_usuario}}">{{$tutor->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    </link>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="lugar" name="lugar" readonly>
                        </div>
                        <div class="col-6">
                            <label for="horas" class="form-label">Horas Requeridas</label>
                            <input type="text" class="form-control" id="horas" name="horas" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fechaFin" class="form-label">Fecha de Finalización</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" readonly>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            @foreach ($estados as $estado)
                            <option value="{{ $estado->id_estado }}">
                                {{ $estado->nombre_estado }}
                            </option>
                            @endforeach
                        </select>

                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-gestion fw-bold">Asignar Proyecto</button>
                </form>

            </div>
        </div>
    </div>

    <div id="tutores-data" data-tutores='@json($tutores)'></div>
    <div id="estudiantes-data" data-estudiantes='@json($estudiantes)'></div>
    <div id="proyectos-data" data-proyectos='@json($proyectos)'></div>

    <script src="{{ asset('js/filtrarTutor.js') }}"></script>
    <script src="{{ asset('js/filtrarEstudiantes.js') }}"></script>
    <script src="{{ asset('js/gestionProyecto.js') }}"></script>


    @endsection