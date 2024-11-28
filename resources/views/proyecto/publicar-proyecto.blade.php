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

    <h2 class="mb-4">Publicar Proyecto</h2>
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
                        <label for="id_seccion" class="form-label">Sección</label>
                        @php
                            $user = auth()->user();
                            $userSeccion = null;

                            // Determinar la sección asociada al usuario según el rol
                            if ($user->hasRole('Estudiante')) {
                                $userSeccion = DB::table('estudiantes')
                                    ->join('secciones', 'estudiantes.id_seccion', '=', 'secciones.id_seccion')
                                    ->where('estudiantes.id_usuario', $user->id_usuario)
                                    ->select('secciones.id_seccion', 'secciones.nombre_seccion')
                                    ->first();
                            } elseif ($user->hasRole('Tutor')) {
                                $userSeccion = DB::table('seccion_tutor')
                                    ->join('secciones', 'seccion_tutor.id_seccion', '=', 'secciones.id_seccion')
                                    ->where('seccion_tutor.id_tutor', $user->id_usuario)
                                    ->select('secciones.id_seccion', 'secciones.nombre_seccion')
                                    ->first();
                            } elseif ($user->hasRole('Coordinador')) {
                                $userSeccion = DB::table('secciones')
                                    ->where('id_coordinador', $user->id_usuario)
                                    ->select('id_seccion', 'nombre_seccion')
                                    ->first();
                            }
                        @endphp
                        <select name="id_seccion" class="form-select" id="id_seccion" required>
                            @if($user->hasRole('Administrador'))
                                <option value="">Seleccionar sección</option>
                                @foreach($departamentos as $departamento)
                                    <optgroup label="{{ $departamento->nombre_departamento }}">
                                        @foreach($secciones->where('id_departamento', $departamento->id_departamento) as $seccion)
                                            <option value="{{ $seccion->id_seccion }}" 
                                                    {{ old('id_seccion') == $seccion->id_seccion ? 'selected' : '' }}>
                                                {{ $seccion->nombre_seccion }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            @else
                                @if ($userSeccion)
                                    <option value="{{ $userSeccion->id_seccion }}" selected>
                                        {{ $userSeccion->nombre_seccion }}
                                    </option>
                                @else
                                    <option value="">No tiene una sección asignada</option>
                                @endif
                            @endif
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