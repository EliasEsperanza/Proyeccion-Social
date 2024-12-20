@extends('layouts.app')
@section('title', 'Editar Proyecto')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container mt-4">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    <script>
        Swal.fire({
            title: "¡Actualizado!",
            text: "El proyecto fue actualizado con éxito.",
            icon: "success",
            timer: 3000,
            timerProgressBar: true,
            didClose: () => {
                // Opcional agregar algo
            }
        });
    </script>
    <script>
        Swal.fire({
            title: "¡Actualizado!",
            text: "El proyecto fue actualizado con éxito.",
            icon: "success",
            timer: 3000,
            timerProgressBar: true,
            didClose: () => {
                // Opcional agregar algo
            }
        });
    </script>
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
                            @php
                            $user = auth()->user();
                            $userSeccion = null;

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

                            @if ($user->hasRole('Administrador'))
                            @foreach ($departamentos as $departamento)
                            <optgroup label="{{ $departamento->nombre_departamento }}">
                                @foreach ($secciones->where('id_departamento', $departamento->id_departamento) as $seccion)
                                <option value="{{ $seccion->id_seccion }}" {{ $seccion->id_seccion == $proyecto->seccion->id_seccion ? 'selected' : '' }}>
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

                <button type="submit" class="btn btn-publicar w-100" id="updateButton" style="background-color: #800000; color: white;">
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
        let editorInstancia;

        ClassicEditor
            .create(document.querySelector('#descripcion'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                language: 'es'
            })
            .then(editor => {
                editorInstancia = editor;
            })
            .catch(error => {
                console.error('Error al inicializar CKEditor:', error);
            });


        document.getElementById('updateButton').addEventListener('click', function(event) {
            event.preventDefault();
            // Obtén  contenido del editor
            const contenido = editorInstancia.getData();
            console.log("Contenido original del editor:", contenido);


            // Sanitizar el contenido 
            const div = document.createElement('div');
            div.innerHTML = contenido;
            const contenidoLimpio = div.textContent || div.innerText || ""; // Extrae solo texto plano
            console.log("Contenido después de sanitizar:", contenidoLimpio);

            // Actualiza el campo textarea con el contenido limpio
            const textarea = document.querySelector('#descripcion');
            textarea.value = contenidoLimpio;
            console.log("Valor del textarea actualizado (sin etiquetas):", textarea.value);


            document.querySelector('#descripcion').value = contenidoLimpio;
            Swal.fire({
                title: "¡Actualización en proceso!",
                text: "El proyecto se está actualizando...",
                icon: "info",
                iconColor: '#800000',
                timer: 3000,
                confirmButtonText: 'OK',
                confirmButtonColor: '#800000',
                timerProgressBar: true,
                didClose: () => {
                    console.log("Formulario enviado.");
                    textarea.form.submit(); // Enviar 
                }
            })
        });
    });
</script>

<style>
    .custom-swal-popup {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
    }

    .swal2-container {
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
</style>
@endsection