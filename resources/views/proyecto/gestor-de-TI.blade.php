@extends('layouts.app')

@section('title', 'Gestor de TI')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-general.css') }}">
<link rel="stylesheet" href="{{ asset('css/gestor-de-TI.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="job-card">
        <h1>Descripcion de Proyecto</h1>

        <div class="section">
            <div class="section-title"><i class="fas fa-file-alt"></i> Descripción:</div>
            <div class="section-content">
                {{ $proyecto->descripcion_proyecto }}
            </div>
        </div>

        <div class="section">
            <div class="section-title"><i class="fas fa-clock"></i> Horas requeridas:</div>
            <div class="section-content">{{ $proyecto->horas_requeridas }} horas</div>
        </div>

        <div class="section">
            <div class="section-title"><i class="fas fa-map-marker-alt"></i> Ubicación:</div>
            <div class="section-content">{{ $proyecto->lugar }}</div>
        </div>

        <div class="section">
            <div class="section-title"><i class="fas fa-building"></i> Sección Departamental:</div>
            <div class="section-content">{{ $proyecto->id_seccion }}</div>
        </div>

        <div class="section">
            <div class="section-title"><i class="fas fa-calendar-alt"></i> Fechas:</div>
            <div class="section-content">
                Fecha de inicio: {{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d-m-Y') }}<br>
                Fecha de fin: {{ \Carbon\Carbon::parse($proyecto->fecha_fin)->format('d-m-Y') }}
            </div>
        </div>

        <div class="section">
            <div class="section-title"><i class="fas fa-cogs"></i> Estado:</div>
            <div class="section-content">
                @if($proyecto->estado == 9)
                    Solicitud
                @elseif($proyecto->estado == 1)
                    En Proceso
                @elseif($proyecto->estado == 2)
                    Completado
                @else
                    No definido
                @endif
            </div>
        </div>

        <div class="button-group">
            <form action="" method="POST" style="display: inline;">
                @csrf
                <button class="btn btn-accept" type="submit">Aceptar</button>
            </form>

            <form action="{}" method="POST" style="display: inline;">
                @csrf
                <button class="btn btn-reject" type="submit">Rechazar</button>
            </form>
        </div>
    </div>
@endsection
