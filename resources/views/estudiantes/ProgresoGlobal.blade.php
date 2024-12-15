@extends('layouts.appE')

@section('title', 'Dashboard - Horas Sociales')

@section('styles')

@endsection

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Información de usuario -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Información del Usuario</h4>
                </div>
                {{ $estudiante }}
                <div class="card-body">
                    <ul class="list-group">
                       <li class="list-group-item"><strong>Nombre:</strong> {{ $estudiante->nombre }}</li>
                        <li class="list-group-item"><strong>Apellido:</strong> {{ $estudiante->apellido }}</li>
                        <li class="list-group-item"><strong>Sección:</strong> {{ $estudiante->seccion }}</li>
                        <li class="list-group-item"><strong>Horas Completadas:</strong> {{ $estudiante->horas_completadas }} horas</li>
                    </ul>

                    <!-- Barra de progreso -->
                    <div class="mt-3">
                        <strong>Progreso:</strong>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $estudiante->progreso }}%;" aria-valuenow="{{ $usuario->progreso }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $usuario->progreso }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial de Proyectos 
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h4>Historial de Proyectos</h4>
                </div>
                <div class="card-body">
                    @if($usuario->proyectos->isEmpty())
                    <p>No hay proyectos asignados.</p>
                    @else
                    <ul class="list-group">
                        @foreach($usuario->proyectos as $proyecto)
                        <li class="list-group-item">
                            <strong>Proyecto:</strong> {{ $proyecto->nombre }} <br>
                            <small><em>{{ $proyecto->fecha_inicio }} - {{ $proyecto->fecha_fin }}</em></small>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>-->
    </div>
</div>


@endsection