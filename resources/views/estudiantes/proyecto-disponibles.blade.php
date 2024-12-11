@extends('layouts.appE')

@section('title', 'Detalles del Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-disponibleE.css') }}">
@endsection

@section('content')

<div class="container py-5">
    <div class="card shadow tarjeta-detalle mx-auto" style="max-width: 800px;">
        <div class="card-body p-4">
            <form action="{{ route('store_solicitud_alumno') }}" method="POST" id="actualizarProyecto">
                @csrf

                <h2 class="titulo-proyecto mb-4 text-center">{{$proyecto->nombre_proyecto }}</h2>
                <p class="descripcion mb-3">
                    <strong>Descripción:</strong> {{ $proyecto->descripcion_proyecto }}
                </p>
                <div class="detalles-proyecto">
                    <p><strong>Horas requeridas:</strong> {{ $proyecto->horas_requeridas }}</p>
                    <p><strong>Ubicación:</strong> {{ $proyecto->lugar }}</p>
                    <p><strong>Sección:</strong>
                        {{ $proyecto->seccion->nombre_seccion ?? 'Sin sección asignada' }}
                    </p>
                    <p><strong>Estado:</strong> {{ $proyecto->estadoo->nombre_estado ?? 'Sin estado definido' }}</p>
                </div>

                <div class="d-flex">
                    <select class="form-select" id="idEstudiante" name="idEstudiante">
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

                <input type="hidden" id="estudiantesSeleccionados" name="estudiantesSeleccionados" value='[]'>
                <input type="hidden" id="id_proyecto" name="id_proyecto" value='{{$proyecto->id_proyecto}}'>

                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-enviar me-2">Enviar solicitud</button>
                    <a href="{{ route('estudiantes.dashboard') }}" class="btn btn-regresar">Regresar</a>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
