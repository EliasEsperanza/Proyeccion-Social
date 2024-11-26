@extends('layouts.app')

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

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="tarjeta">
            <div class="encabezado-tarjeta">
                <h2>Revision de solicitud</h2>
                <p>Proyecto: <strong> {{ $proyecto->nombre_proyecto }} </strong></p>
                <p>Estudiante: <strong> {{ $usuario->name }}</strong></p>
            </div>
            <div>
                <div class="campo-formulario">
                    <label for="horasTrabajadas" class="form-label">Horas solicitadas</label>
                    <input type="number" class="form-control" id="horasTrabajadas" name="horasTrabajadas" disabled
                        value="{{ $solicitud->valor }}" placeholder="Ingrese las horas trabajadas" min="0"
                        max="8" required>
                    @error('horasTrabajadas')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="campo-formulario">
                    <!--Visor de documentos-->
                    <label for="documento" class="form-label">Documento comprobante</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="documento" name="documento" disabled
                            value="{{ $solicitud->documento }}" placeholder="Seleccione un documento" required>
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2"
                            onclick="window.open('{{ asset($rutaDocs . $solicitud->documento) }}', '_blank')">
                            <i class="fas fa-eye text-primary"></i> Ver documento </button>
                    </div>
                </div>
                <div class="campo-formulario">
                    <p>Progreso actual: <strong> {{ $estudiante->horas_sociales_completadas ?? 0 }} de
                            {{ $proyecto->horas_requeridas }} horas</strong></p>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <a href="{{ route('solicitudesProyectos', ['id' => $solicitud->id_proyecto]) }}"
                            class="btn boton-secundario">Regresar</a>
                    </div>

                    <div class="col-md-4 d-flex justify-content-center align-items-center gap-2">

                        <!--Formulario separado para denegar solicitud-->
                        <form
                            action="{{ route('denegarSolicitud', ['id' => $proyecto->id_proyecto, 'solicitud' => $solicitud->solicitud_id]) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn boton-secundario">Denegar solicitud</button>
                        </form>

                        <!--Boton para aprobar solicitud-->
                        <form
                            action="{{ route('aprobarSolicitud', ['id' => $proyecto->id_proyecto, 'solicitud' => $solicitud->solicitud_id]) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn boton-principal">Aprobar solicitud</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
