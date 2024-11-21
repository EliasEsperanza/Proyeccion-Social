@extends('layouts.app')
@section('title', 'Editar Proyecto')
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

    <h2 class="mb-4">Editar proyecto de horas sociales</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('proyectos.proyectos_update', $proyecto->id_proyecto) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título del proyecto</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $proyecto->nombre_proyecto }}" required>
                </div>
               
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del proyecto</label>
                    <textarea class="form-control" id="descripcion" name="descripcion">{{ $proyecto->descripcion_proyecto }}</textarea>
                </div>
               
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="horas" class="form-label">Horas Requeridas</label>
                        <input type="number" class="form-control" id="horas" name="horas" value="{{ $proyecto->horas_requeridas }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ $proyecto->lugar }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="id_seccion" class="form-label">Sección/Departamento</label>
                        <select name="id_seccion" class="form-select" id="id_seccion" required>
                            <option value="">Seleccionar sección</option>
                            @foreach($departamentos as $departamento)
                                <optgroup label="{{ $departamento->nombre_departamento }}">
                                    @foreach($secciones->where('id_departamento', $departamento->id_departamento) as $seccion)
                                        <option value="{{ $seccion->id_seccion }}" {{ $seccion->id_seccion == $proyecto->seccion->id_seccion ? 'selected' : '' }}>
                                            {{ $seccion->nombre_seccion }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-publicar w-100" style="background-color: #800000; color: white;">
                    Actualizar Proyecto
                </button>
            </form>
        </div>
    </div>
</div>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#descripcion'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                language: 'es'
            })
            .catch(error => {
                console.error('Error al inicializar CKEditor:', error);
            });
    });
</script>
@endsection