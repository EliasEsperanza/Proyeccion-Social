@extends('layouts.appE')

@section('title', 'Solicitud de Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/publiE.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-2"><strong>Solicitud de Proyecto</strong></h1>
    <h3>Sección = {{$proyectoEstudiante->id_seccion}}</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <form id="formProyecto" method="POST" action="{{ route('proyectos.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombreProyecto" name="nombre_proyecto" placeholder="Nombre del Proyecto" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Estudiantes</label>
                    <div class="input-group mb-3">
                        <select class="form-control" id="nombreEstudiante">
                            <option selected disabled>Seleccione un estudiante</option>
                        </select>

                        <button type="button" class="btn btn-primary btn-gestion fw-bold" onclick="agregarEstudiante()">Agregar estudiante</button>
                    </div>
                    <ul class="mt-3" id="estudiantesList">
                            <!-- Aquí se añadirán los estudiantes -->
                        </ul>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del proyecto</label>
                    <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 mb-4">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="lugar" placeholder="Ubicación" required>
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio" required>
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="fechaFin" class="form-label">Fecha de finalización</label>
                        <input type="date" class="form-control" id="fechaFin" name="fecha_fin" required>
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
    // Obtener el id de la sección desde el servidor
    const idSeccion = {{$proyectoEstudiante->id_seccion}};
    const selectEstudiantes = document.querySelector('#nombreEstudiante');

    // Cargar estudiantes por sección
    fetch(`/estudiantes-por-seccion/${idSeccion}`)
        .then(response => response.json())
        .then(estudiantes => {
            estudiantes.forEach(estudiante => {
                const option = document.createElement('option');
                option.value = estudiante.id_estudiante;
                option.textContent = estudiante.usuario.name;
                selectEstudiantes.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar estudiantes:', error));

    // Inicializar CKEditor para la descripción
    ClassicEditor
        .create(document.querySelector('#descripcion'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
            language: 'es'
        })
        .then(editor => {
            // Cuando el formulario se envíe, copiamos el valor de CKEditor al campo
            document.querySelector('#formProyecto').addEventListener('submit', function() {
                const descripcionContent = editor.getData();
                document.querySelector('#descripcion').value = descripcionContent;
            });
        })
        .catch(error => {
            console.error(error);
        });

    // Agregar estudiante a la lista
    function agregarEstudiante() {
        const selectedEstudiante = selectEstudiantes.value;
        if (selectedEstudiante) {
            const estudianteText = selectEstudiantes.options[selectEstudiantes.selectedIndex].textContent;
            const li = document.createElement('li');
            li.textContent = estudianteText;
            document.querySelector('#estudiantesList').appendChild(li);
            selectEstudiantes.value = '';  // Limpiar el select
        }
    }

    // Manejar el evento de submit del formulario
    document.querySelector('#formProyecto').addEventListener('submit', function(event) {
        console.log('Formulario de solicitud de proyecto enviado');
        console.log('Nombre del Proyecto:', document.querySelector('#nombreProyecto').value);
        console.log('Descripción del Proyecto:', document.querySelector('#descripcion').value);
        console.log('Estudiantes:', document.querySelector('#estudiantesList').innerText);
        console.log('Ubicación:', document.querySelector('#ubicacion').value);
        console.log('Fecha de inicio:', document.querySelector('#fechaInicio').value);
        console.log('Fecha de finalización:', document.querySelector('#fechaFin').value);
    });
</script>
@endsection