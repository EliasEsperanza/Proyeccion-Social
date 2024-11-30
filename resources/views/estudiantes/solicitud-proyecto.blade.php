@extends('layouts.appE')

@section('title', 'Solicitud de Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/publiE.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-2"><strong>Solicitud de Proyecto</strong></h1>
    @if (session('error'))
            <p class="alert alert-danger">{{ session('error') }}</p>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
            <form id="formProyecto" method="POST" action="{{ route('proyectos.store_solicitud') }}">
                @csrf

                <div class="mb-4">
                    <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombreProyecto" name="nombre_proyecto" placeholder="Nombre del Proyecto" required>
                </div>
                <input type="hidden" name="id_seccion" value="{{ $proyectoEstudiante->id_seccion }}">

                <div class="mb-4">
                    <label class="form-label">Estudiantes</label>
                    <div class="input-group mb-3">
                        <input type="hidden" id="estudiantesIds" name="estudiantes" value="" required>
                        <select class="form-control" id="nombreEstudiante">
                            <option selected disabled>Seleccione un estudiante</option>
                        </select>

                        <button type="button" class="btn btn-primary btn-gestion fw-bold" onclick="agregarEstudiante()">Agregar estudiante</button>
                    </div>
                    <ul class="mt-3" id="estudiantesList"><!-- Aquí se añadirán los estudiantes --></ul>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del proyecto</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" required>{{ old('descripcion') }}</textarea>
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
                        <input type="date" class="form-control" id="fechaFin" name="fecha_fin" required disabled>
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
    // Elementos de entrada de fecha
    const fechaInicio = document.getElementById("fechaInicio");
    const fechaFin = document.getElementById("fechaFin");

    // Establecer la fecha mínima para el campo de fecha inicial (hoy)
    const hoy = new Date().toISOString().split("T")[0];
    fechaInicio.min = hoy;

    // Deshabilitar el campo de fecha final por defecto
    fechaFin.disabled = true;

    // Evento para habilitar y configurar restricciones en la fecha final
    fechaInicio.addEventListener("change", function () {
      if (fechaInicio.value) {
        const fechaInicialSeleccionada = new Date(fechaInicio.value);
        
        // Habilitar el campo de fecha final
        fechaFin.disabled = false;

        // Calcular la fecha mínima (6 meses después de la fecha inicial)
        const fechaMin = new Date(fechaInicialSeleccionada);
        fechaMin.setMonth(fechaMin.getMonth() + 6);
        fechaFin.min = fechaMin.toISOString().split("T")[0];

        // Calcular la fecha máxima (5 años después de la fecha inicial)
        const fechaMax = new Date(fechaInicialSeleccionada);
        fechaMax.setFullYear(fechaMax.getFullYear() + 5);
        fechaFin.max = fechaMax.toISOString().split("T")[0];
    } else {
        // Si no se selecciona una fecha inicial, deshabilitar la fecha final
        fechaFin.disabled = true;
    }
    });
</script>

<script>
    const idSeccion = {{$proyectoEstudiante->id_seccion}};
    const selectEstudiantes = document.querySelector('#nombreEstudiante');
    const estudiantesList = document.querySelector('#estudiantesList');
    const estudiantesInput = document.querySelector('#estudiantesIds');
    let estudiantesSeleccionados = [];

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


    ClassicEditor
        .create(document.querySelector('#descripcion'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
            language: 'es'
        })
        .then(editor => {

            document.querySelector('#formProyecto').addEventListener('submit', function() {
                const descripcionContent = editor.getData();
                document.querySelector('#descripcion').value = descripcionContent;

                estudiantesInput.value = JSON.stringify(estudiantesSeleccionados);
            });
        })
        .catch(error => {
            console.error(error);
        });

    function agregarEstudiante() {
        const selectedEstudianteId = selectEstudiantes.value;
        const selectedEstudianteText = selectEstudiantes.options[selectEstudiantes.selectedIndex]?.textContent;

        if (selectedEstudianteId && !estudiantesSeleccionados.includes(selectedEstudianteId)) {
            estudiantesSeleccionados.push(selectedEstudianteId);

            const li = document.createElement('li');
            li.textContent = selectedEstudianteText;
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.dataset.id = selectedEstudianteId;

            const removeButton = document.createElement('button');
            removeButton.textContent = 'Eliminar';
            removeButton.className = 'btn btn-danger btn-sm';
            removeButton.onclick = () => eliminarEstudiante(selectedEstudianteId, li);

            li.appendChild(removeButton);
            estudiantesList.appendChild(li);
        } else {
            alert('El estudiante ya ha sido agregado o no es válido.');
        }

        selectEstudiantes.value = '';
    }


    function eliminarEstudiante(id, liElement) {

        estudiantesSeleccionados = estudiantesSeleccionados.filter(estudianteId => estudianteId !== id);

        liElement.remove();
    }

    document.querySelector('#formProyecto').addEventListener('submit', function(event) {
        console.log('Formulario enviado con los siguientes datos:');
        console.log('Nombre del Proyecto:', document.querySelector('#nombreProyecto').value);
        console.log('Descripción del Proyecto:', document.querySelector('#descripcion').value);
        console.log('Estudiantes:', estudiantesSeleccionados);
        console.log('Ubicación:', document.querySelector('#ubicacion').value);
        console.log('Fecha de inicio:', document.querySelector('#fechaInicio').value);
        console.log('Fecha de finalización:', document.querySelector('#fechaFin').value);
        console.log('ID de la Sección:', idSeccion);
    });
</script>


@endsection
