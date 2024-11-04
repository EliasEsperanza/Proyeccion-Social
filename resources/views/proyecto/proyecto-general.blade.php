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
        <div class="card-body p-4"> <!-- Añadimos padding aquí -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title">Proyectos Existentes</h5>

                <form class="d-flex ms-auto position-relative">
                    <input class="form-control rounded-pill ps-5" type="search" placeholder="Buscar" aria-label="Buscar">
                    <i class="bi bi-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                </form>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th> <!-- Checkbox de Seleccionar Todos -->
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
            <tbody id="projectTableBody">
                <!-- Aquí puedes agregar un bucle para mostrar los proyectos desde la base de datos -->
                <tr class="py-3"> <!-- Añadimos py-3 a las filas para más espacio vertical -->
                    <td><input type="checkbox" class="selectProject"></td>
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

        <!-- Mostrar rango de resultados y paginación -->
        <div class="d-flex justify-content-between align-items-center px-4"> <!-- Añadimos padding aquí -->
            <p>Showing 1 to 10 of 50 results</p>

            <!-- Paginación -->
            <nav aria-label="Paginación de proyectos">
                <ul class="pagination mb-0">
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                </ul>
            </nav>
        </div>
        
        <div class="button-group mt-3 px-4 mb-4">
    <button class="btn btn-success me-2">Generar PDF</button>
    <button class="btn btn-primary">Generar Excel</button>
</div>

    </div>
</div>

<script src="{{ asset('js/proyecto-general.js') }}"></script>
@endsection
    