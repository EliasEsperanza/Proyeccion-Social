@extends('layouts.app')

@section('title', 'Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
<h1>Proyectos</h1>
<div class="tabla-contenedor shadow-sm rounded bg-white">
    <div class="table-responsive ">
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título del proyecto</th>
                    <th>Estudiantes</th>
                    <th>Tutor</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de finalización</th>
                    <th>Ubicación</th>
                    <th>Progreso</th>
                    <th>Estado</th>
                    <th>Sección/Departamento</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @foreach($ListProyecto as $proyecto)
                <tr>
                    <td>{{$proyecto->nombre_proyecto}}</td>
                    <td>
                        @if($proyecto->estudiantes->isNotEmpty())
                            @foreach($proyecto->estudiantes as $estudiante)
                                <li>{{$estudiante->usuario->name}}</li>
                            @endforeach
                        @else
                            <p>no hay estudiantes asignados</p> 
                        @endif
                    </td>
                    <td>{{ $proyecto->tutorr?->name ?? 'Sin tutor asignado' }}</td>
                    <td>{{$proyecto->fecha_inicio}}</td>
                    <td>{{$proyecto->fecha_fin}}</td>
                    <td>{{$proyecto->lugar}}</td>
                    <td>-</td>
                    <td>{{$proyecto->estadoo->nombre_estado}}</td>
                    <td>
                    @if($proyecto->tutorr?->seccionesTutoreadas)
                        @foreach ($proyecto->tutorr->seccionesTutoreadas as $seccion)
                            <li>{{ $seccion->nombre_seccion ?? 'Sin seccion asignada' }}</li>
                        @endforeach
                    @else
                        <li>No hay secciones tutoreadas</li>
                    @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('proyecto.proyecto-editar', ['id' => $proyecto->id_proyecto]) }}" class="btn btn-light btn-sm p-2 px-3"><i class="bi bi-pencil text-warning"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

        <div class="p-3 d-flex flex-column flex-md-row justify-content-between align-items-center bg-light border-top">
            <span class="text-muted mb-2 mb-md-0">Mostrando 1 a 10 de 50 resultados</span>
            <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>10</option>
                    <option>20</option>
                    <option>50</option>
                </select>
                <span>por página</span>
            </div>
            <ul class="paginacion d-flex gap-2 mb-0">
                <li class="pagina-item activo">
                    <a class="pagina-enlace" href="#">1</a>
                </li>
                <li class="pagina-item"><a class="pagina-enlace" href="#">2</a></li>
                <li class="pagina-item"><a class="pagina-enlace" href="#">3</a></li>
                <li class="pagina-item"><a class="pagina-enlace" href="#">4</a></li>
                <li class="pagina-item"><a class="pagina-enlace" href="#">5</a></li>
                <li class="pagina-item"><a class="pagina-enlace" href="#"><i class="bi bi-chevron-right"></i></a></li>
            </ul>
        </div>
    


        <div class="d-flex justify-content-end">
            
            <div class="button-group mt-3 px-4 mb-4">
                <a href="#" class="btn btn-success me-2">Generar PDF</a>
                <a href="#" class="btn btn-primary">Generar Excel</a>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('js/proyecto-general.js') }}"></script>
@endsection