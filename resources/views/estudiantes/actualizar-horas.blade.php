@extends('layouts.appE')

@section('title', 'Dashboard - Horas Sociales')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/actualizarhoraE.css') }}">
@endsection

@section('content')
    <div class="container contenedor-principal">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($proyecto == null)
            <div class="alert alert-danger" role="alert">
                No tiene un proyecto asignado
            </div>

            <!--boton de volver-->
            <a href="{{ route('proyectomio') }}" class="btn boton-secundario">Volver</a>
        @else
            <div class="tarjeta">
                <div class="encabezado-tarjeta">
                    <h2>Actualizar horas del proyecto</h2>
                    <p>Proyecto: <strong> {{ $proyecto->nombre_proyecto }} </strong></p>
                    <p>Estudiante: <strong> {{ $horas->nombre }}</strong></p>
                    <p>Tutor: <strong> {{ $tutor->name ?? "Sin asignar aun." }}</strong></p>
                </div>
                <form action="{{ route('estudiante.actualizarHoras') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="campo-formulario">
                        <label for="horasTrabajadas" class="form-label">Horas trabajadas</label>
                        <input type="number" class="form-control" id="horasTrabajadas" name="horasTrabajadas"
                            value="{{ old('horasTrabajadas') }}" placeholder="Ingrese las horas trabajadas" min="10"
                            max="128" required>
                        @error('horasTrabajadas')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="campo-formulario">
                        <label for="documentos" class="form-label">Agregar documentos</label>
                        <input type="file" class="form-control" id="documentos" name="documentos" required
                            accept=".pdf">
                        @error('documentos')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="campo-formulario">
                        <p>Progreso actual: <strong> {{ $horas->horas_sociales_completadas }} de
                                {{ $proyecto->horas_requeridas }} horas</strong></p>
                    </div>
                    <input type="hidden" name="idProyecto" value="{{ $proyecto->id_proyecto }}">
                    <input type="hidden" name="idEstudiante " value="{{ $horas->id_estudiante }}">
                    <input type="hidden" name="horasRequeridas" value="{{ $proyecto->horas_requeridas }}">

                    <div class="d-flex justify-content-between">
                        <a href="{{route('proyectomio')}}" class="btn boton-secundario">Volver al proyecto</a>
                        <button type="submit" class="btn boton-principal">Enviar solicitud</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
@endsection
