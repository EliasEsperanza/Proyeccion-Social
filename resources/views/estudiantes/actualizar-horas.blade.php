@extends('layouts.appE')

@section('title', 'Dashboard - Horas Sociales')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/actualizarhoraE.css') }}">
@endsection

@section('content')
<div class="container contenedor-principal">
        <div class="tarjeta">
            <div class="encabezado-tarjeta">
                <h2>Actualizar horas del proyecto</h2>
                <p>Gestor de TI</p>
            </div>
            <form>
                <div class="campo-formulario">
                    <label for="horasTrabajadas" class="form-label">Horas trabajadas</label>
                    <input type="number" class="form-control" id="horasTrabajadas" placeholder="Ingrese las horas trabajadas">
                </div>
                <div class="campo-formulario">
                    <label for="fechaTrabajo" class="form-label">Fecha de trabajo</label>
                    <input type="date" class="form-control" id="fechaTrabajo" placeholder="dd/mm/aaaa">
                </div>
                <div class="campo-formulario">
                    <p>Progreso actual: <strong>15 de 50 horas</strong></p>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn boton-secundario">Volver al proyecto</a>
                    <button type="submit" class="btn boton-principal">Actualizar Horas</button>
                </div>
            </form>
        </div>
    </div>
@endsection