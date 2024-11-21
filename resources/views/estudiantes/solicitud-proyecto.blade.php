@extends('layouts.appE')

@section('title', 'Solicitud de Proyecto')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/publiE.css') }}">

@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-2"><strong>Solicitud de proyecto</strong></h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form>
                <div class="mb-4">
                    <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombreProyecto" placeholder="Nombre del Proyecto">
                </div>

                <div class="mb-4">
                    <label for="nombreEstudiante" class="form-label">Estudiantes</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nombreEstudiante" placeholder="Nombre del estudiante">
                        <button type="button" class="btn btn-danger">Agregar estudiante</button>
                    </div>
                    <ul class="mt-3">
                        <li>Kevin Nathanael Granados Perez</li>
                        <li>Carlos Orlando Del Cid</li>
                        <li>Edars Ariel Viera Lazo</li>
                    </ul>
                </div>

                <div class="mb-5">
                    <label for="descripcion" class="form-label">Descripción del proyecto</label>
                    <textarea class="form-control" id="descripcion" rows="4" placeholder="Descripción del proyecto"></textarea>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 mb-4">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" placeholder="Ubicación">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                        <input type="date" class="form-control" id="fechaInicio">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="fechaFin" class="form-label">Fecha de finalización</label>
                        <input type="date" class="form-control" id="fechaFin">
                    </div>
                </div>

                <button type="submit" class="btn btn-danger w-100">Enviar solicitud</button>
            </form>
        </div>
    </div>
</div>

<!-- Scripts de CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#descripcion'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
            language: 'es'
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
