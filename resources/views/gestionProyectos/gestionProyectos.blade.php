@extends('layouts.app') 

@section('title', 'Gestión de Proyectos')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/gestionProyecto.css') }}">

@endsection

@section('content')

<div class="container ">
    
    <div class="container">
        <h1 class="mb-4">Gestión de Proyectos</h1>
    
        <div class="card w-100">
            <div class="card-body">
            <form action="" method="POST">
                    @csrf
            <div class="mb-3">
                <label for="proyectosDisponibles" class="form-label">Proyectos Disponibles</label>
                <select class="form-select" id="proyectosDisponibles" name="proyecto_id">
                    <option selected disabled>Seleccione un proyecto</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Sección o Departamento</label>
                <div class="input-group mb-3">
                    <select class="form-control" id="seccion" name="seccion_id">
                        <option selected disabled>Seleccione una sección</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Estudiantes</label>
                <div class="input-group mb-3">
                    <select class="form-control" id="nombreEstudiante">
                        <option selected disabled>Seleccione un estudiante</option>
                    </select>
                    <button type="button" class="btn btn-primary btn-gestion fw-bold" onclick="agregarEstudiante()">Agregar estudiante</button>
                </div>
            </div>

            <!-- Campo oculto para almacenar estudiantes seleccionados -->
            <input type="hidden" id="estudiantesSeleccionados" name="estudiantes">

            <ul id="listaEstudiantes" class="list-unstyled"></ul>

            <div class="mb-3">
                <label for="tutor" class="form-label">Tutor</label>
                <select class="form-control" id="tutor" name="tutor_id">
                    <option selected disabled>Seleccione un tutor</option>
                </select>
            </div>


            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" readonly>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="fechaInicio" name="fecha_inicio" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fechaFin" class="form-label">Fecha de Finalización</label>
                    <input type="date" class="form-control" id="fechaFin" name="fecha_fin" readonly>
                </div>
            </div>

            <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" id="estado" name="estado_id">
                        <option selected disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-gestion fw-bold">Crear Proyecto</button>
        </form> 

            </div>
        </div>
    </div>
    

<script src="{{ asset('js/gestionProyecto.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/secciones-disponibles')
        .then(response => response.json())
        .then(secciones => {
            const selectSeccion = document.getElementById('seccion');
            secciones.forEach(seccion => {
                const option = document.createElement('option');
                option.value = seccion.id_seccion;
                option.textContent = `${seccion.nombre_seccion} - ${seccion.nombre_departamento}`;
                selectSeccion.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar secciones:', error));
});

document.getElementById('seccion').addEventListener('change', function () {
    const idSeccion = this.value;
    const selectEstudiantes = document.getElementById('nombreEstudiante');
    const selectTutores = document.getElementById('tutor');

    // Limpiar estudiantes
    selectEstudiantes.innerHTML = '<option selected disabled>Seleccione un estudiante</option>';
    
    // Limpiar tutores
    selectTutores.innerHTML = '<option selected disabled>Seleccione un tutor</option>';

    // Fetch estudiantes por sección (código existente)
    fetch(`/estudiantes-por-seccion/${idSeccion}`)
        .then(response => response.json())
        .then(estudiantes => {
            estudiantes.forEach(estudiante => {
                const option = document.createElement('option');
                option.value = estudiante.id_estudiante;
                option.textContent = estudiante.usuario.name;
                selectEstudiantes.appendChild(option);
            });

            sortSelectOptions(selectEstudiantes);
        })
        .catch(error => console.error('Error al cargar estudiantes:', error));

    // Nuevo fetch para cargar tutores por sección
    fetch(`/obtener-tutores-por-seccion/${idSeccion}`)
        .then(response => response.json())
        .then(tutores => {
            tutores.forEach(tutor => {
                console.log(tutor);
                const option = document.createElement('option');
                option.value = tutor.id_tutor;                
                option.textContent = tutor.name || `Tutor ${tutor.id_usuario}`;
                selectTutores.appendChild(option);
            });
            sortSelectOptions(selectTutores);
        })
        .catch(error => console.error('Error al cargar tutores:', error));
});

function agregarEstudiante() {
    const selectEstudiantes = document.getElementById('nombreEstudiante');
    const listaEstudiantes = document.getElementById('listaEstudiantes');
    const estudianteId = selectEstudiantes.value;
    const estudianteNombre = selectEstudiantes.options[selectEstudiantes.selectedIndex]?.text;

    if (!estudianteId) {
        alert('Seleccione un estudiante antes de agregar.');
        return;
    }

    const estudianteYaAgregado = Array.from(listaEstudiantes.children).some(li => li.dataset.id === estudianteId);
    if (estudianteYaAgregado) {
        alert('Este estudiante ya ha sido agregado.');
        return;
    }

    const li = document.createElement('li');
    li.textContent = estudianteNombre;
    li.dataset.id = estudianteId;

    const btnEliminar = document.createElement('button');
    btnEliminar.textContent = 'Eliminar';
    btnEliminar.className = 'btn btn-danger btn-sm ms-2';
    btnEliminar.onclick = () => {
        li.remove();

        const optionYaExiste = Array.from(selectEstudiantes.options).some(option => option.value === estudianteId);
        if (!optionYaExiste) {
            const option = document.createElement('option');
            option.value = estudianteId;
            option.textContent = estudianteNombre;
            selectEstudiantes.appendChild(option);

            sortSelectOptions(selectEstudiantes);
        }
    };

    li.appendChild(btnEliminar);
    listaEstudiantes.appendChild(li);

    selectEstudiantes.value = '';
}

function sortSelectOptions(select) {
    const options = Array.from(select.options).slice(1);
    options.sort((a, b) => a.text.toLowerCase().localeCompare(b.text.toLowerCase()));

    selectEstudiantes.innerHTML = '<option selected disabled>Seleccione un estudiante</option>';
    selectTutores.innerHTML = '<option selected disabled>Seleccione un tutor</option>';

    options.forEach(option => select.appendChild(option));
}

document.addEventListener('DOMContentLoaded', function () {
    const selectProyectos = document.getElementById('proyectosDisponibles');
    const tutorField = document.getElementById('tutor');
    const ubicacionField = document.getElementById('ubicacion');
    const fechaInicioField = document.getElementById('fechaInicio');
    const fechaFinField = document.getElementById('fechaFin');
    const estadoField = document.getElementById('estado');

    fetch('/proyectos-disponibles')
        .then(response => response.json())
        .then(proyectos => {
            proyectos.forEach(proyecto => {
                const option = document.createElement('option');
                option.value = proyecto.id_proyecto;
                option.textContent = proyecto.nombre_proyecto;

                option.dataset.tutor = proyecto.tutorr?.name || 'No asignado';
                option.dataset.ubicacion = proyecto.lugar;
                option.dataset.fechaInicio = proyecto.fecha_inicio;
                option.dataset.fechaFin = proyecto.fecha_fin;
                option.dataset.estado = proyecto.estadoo?.nombre_estado || 'No definido';

                selectProyectos.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar proyectos disponibles:', error));

    selectProyectos.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        tutorField.value = selectedOption.dataset.tutor || '';
        ubicacionField.value = selectedOption.dataset.ubicacion || '';
        fechaInicioField.value = selectedOption.dataset.fechaInicio || '';
        fechaFinField.value = selectedOption.dataset.fechaFin || '';
        estadoField.value = selectedOption.dataset.estado || '';
    });
});
</script>
@endsection