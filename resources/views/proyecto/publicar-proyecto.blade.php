@extends('layouts.app')
@section('title', 'Publicar Proyecto')
@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="mb-4">Publicar nuevo proyecto de horas sociales</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('proyectos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título del proyecto</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" 
                           value="{{ old('titulo') }}" required>
                </div>
               
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del proyecto</label>
                    <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
                </div>
               
                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label for="horas" class="form-label">Horas Requeridas</label>
                        <input type="number" class="form-control" id="horas" name="horas" 
                               value="{{ old('horas') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                               value="{{ old('ubicacion') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="id_seccion" class="form-label">Sección/Departamento</label>
                        <select name="id_seccion" class="form-select" id="id_seccion">
                            <option selected>Seleccionar departamento</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-publicar w-100" 
                        style="background-color: #800000; color: white;">
                    Publicar Proyecto
                </button>
            </form>
        </div>
    </div>
</div>

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