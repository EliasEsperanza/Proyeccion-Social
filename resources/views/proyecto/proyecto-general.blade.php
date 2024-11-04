@extends('layouts.app')

@section('title', 'Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
@endsection

@section('content')

<div class="container my-8">
    <h1 class="mb-4">Proyectos</h1>
    
    <!-- Tabla de proyectos -->
    <div class="card w-100 mb-4">
        <div class="card-body">
            <h5 class="card-title">Proyectos Existentes</h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título del proyecto</th>
                        <th>Estudiantes</th>
                        <th>Tutor</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de finalización</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th>Sección/Departamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí puedes agregar un bucle para mostrar los proyectos desde la base de datos -->
                    <tr>
                        <td>Gestor de TI</td>
                        <td>Kevin Nata</td>
                        <td>Josselin</td>
                        <td>10-10-24</td>
                        <td>10-07-25</td>
                        <td>UES-FMO</td>
                        <td>Anteproyecto</td>
                        <td>Sistemas Inform</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary">Editar</button>
                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </td>
                    </tr>
                    <!-- Fin del bucle -->
                </tbody>
            </table>
            <div class="button-group">
                <button class="btn btn-success">Generar PDF</button>
                <button class="btn btn-primary">Generar Excel</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/proyecto-general.js') }}"></script>
@endsection
