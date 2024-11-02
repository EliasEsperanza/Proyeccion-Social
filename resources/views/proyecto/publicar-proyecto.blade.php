@extends('layouts.app')

@section('title', 'Publicar Proyecto')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Publicar nuevo proyecto de horas sociales</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título del proyecto</label>
                    <input type="text" class="form-control" id="titulo" placeholder="Título del proyecto">
                </div>
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del proyecto</label>
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                        <div class="btn-toolbar flex-wrap">
                            <button type="button" class="btn btn-light btn-sm me-1"><strong>B</strong></button>
                            <button type="button" class="btn btn-light btn-sm me-1"><em>I</em></button>
                            <button type="button" class="btn btn-light btn-sm me-1"><u>U</u></button>
                            <button type="button" class="btn btn-light btn-sm me-3"><i class="bi bi-link-45deg"></i></button>
                            <button type="button" class="btn btn-light btn-sm me-1"><i class="bi bi-code-slash"></i></button>
                            <button type="button" class="btn btn-light btn-sm me-1"><i class="bi bi-list-ul"></i></button>
                            <button type="button" class="btn btn-light btn-sm ms-3"><i class="bi bi-image"></i></button>
                        </div>
                        <div class="d-flex">
                            <small class="fw-bold text-dark me-2">Edit</small>
                            <small class="text-muted">Preview</small>
                        </div>
                    </div>
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
                
                <button type="submit" class="btn btn-publicar w-100" style="background-color: #800000;">Publicar Proyecto</button>
            </form>
        </div>
    </div>
</div>
@endsection
