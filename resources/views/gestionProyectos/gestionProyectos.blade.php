@extends('layouts.app') 

@section('title', 'Gestión de Proyectos')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/gestionProyecto.css') }}">

@endsection

@section('content')

<div class="container ">
    
    <div class="container">
        <h1 class="mb-4">Gestión de Proyectos</h1>
    
        <div class="card w-100">
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
                        <input type="text" class="form-control" id="nombreProyecto">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Estudiantes</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="nombreEstudiante" placeholder="Nombre del estudiante">
                            <button type="button" class="btn btn-primary btn-gestion fw-bold" onclick="agregarEstudiante()">Agregar estudiante</button>
                        </div>
    
                        <ul id="listaEstudiantes" class="list-unstyled">
                            
                        </ul>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tutor" class="form-label">Tutor</label>
                            <input type="text" class="form-control" id="tutor" placeholder="Ingrese el nombre del tutor">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" placeholder="Ingrese la ubicación del proyecto">
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                            <input type="date" class="form-control" id="fechaInicio">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fechaFinalizacion" class="form-label">Fecha de finalización</label>
                            <input type="date" class="form-control" id="fechaFinalizacion">
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="seccion" class="form-label">Sección/Departamento</label>
                            <select class="form-select" id="seccion">
                                <option selected>Seleccionar departamento</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado">
                                <option selected>En progreso</option>
                                <option value="finalizado">Finalizado</option>
                            </select>
                        </div>
                    </div>
    
                    <button type="submit" class="btn btn-primary w-100 btn-gestion fw-bold">Crear Proyecto</button>
                </form>
            </div>
        </div>
    </div>
    

<script src="{{ asset('js/gestionProyecto.js') }}"></script>
@endsection
