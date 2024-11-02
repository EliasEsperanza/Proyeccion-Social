@extends('layouts.app')

@section('title', 'Publicar Proyecto')

@section('content')
<div class="container mt-4">
    <h2>Publicar nuevo proyecto de horas sociales</h2>
    <form>
        <div class="mb-3">
            <label for="titulo" class="form-label">Título del proyecto</label>
            <input type="text" class="form-control" id="titulo" placeholder="Título del proyecto">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción del proyecto</label>
            <textarea class="form-control" id="descripcion" rows="4" placeholder="Descripción del proyecto"></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="horas" class="form-label">Horas Requeridas</label>
                <input type="number" class="form-control" id="horas" placeholder="Horas Requeridas">
            </div>
            <div class="col-md-6 mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" placeholder="Ubicación">
            </div>
        </div>
        <div class="mb-3">
            <label for="departamento" class="form-label">Sección/Departamento</label>
            <select class="form-select" id="departamento">
                <option selected>Seleccionar departamento</option>
                <option value="1">Departamento 1</option>
                <option value="2">Departamento 2</option>
                <option value="3">Departamento 3</option>
            </select>
        </div>
        <button type="submit" class="btn btn-dark" style="background-color: #800000;">Publicar Proyecto</button>
    </form>
</div>
@endsection
