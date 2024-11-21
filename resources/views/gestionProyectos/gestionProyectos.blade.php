@extends('layouts.app')

@section('title', 'Gesti贸n de Proyectos')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/gestionProyecto.css') }}">
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <h1 class="mb-4">Gesti贸n de Proyectos</h1>

    <div class="card w-100">
        <div class="card-body">
            <form id="asignarForm" action="{{ route('proyectos.asignar') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Secci贸n o Departamento</label>
                    <div class="input-group mb-3">
                        <select class="form-control" id="seccion" name="seccion_id">
                            <option selected disabled>Seleccione una secci贸n</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="proyectosDisponibles" class="form-label">Proyectos Disponibles</label>
                    <select class="form-select" id="proyectosDisponibles" name="proyecto_id">
                        <option selected disabled>Seleccione un proyecto</option>
                    </select>
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
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-control" id="estado" name="estado_id">
                        <option selected disabled>Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Asignar Proyecto</button>
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
    const selectProyectos = document.getElementById('proyectosDisponibles');
    
    selectEstudiantes.innerHTML = '<option selected disabled>Seleccione un estudiante</option>';
    selectTutores.innerHTML = '<option selected disabled>Seleccione un tutor</option>';
    selectProyectos.innerHTML = '<option selected disabled>Seleccione un proyecto</option>';

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

    fetch(`/obtener-tutores-por-seccion/${idSeccion}`)
        .then(response => response.json())
        .then(tutores => {
            tutores.forEach(tutor => {
                const option = document.createElement('option');
                option.value = tutor.id_tutor;                
                option.textContent = tutor.name || `Tutor ${tutor.id_usuario}`;
                selectTutores.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar tutores:', error));

    fetch(`/proyectos-por-seccion/${idSeccion}`)
        .then(response => response.json())
        .then(proyectos => {
            proyectos.forEach(proyecto => {
                const option = document.createElement('option');
                option.value = proyecto.id_proyecto;
                option.textContent = proyecto.nombre_proyecto;
                selectProyectos.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar proyectos:', error));
});

function agregarEstudiante() {
    const selectEstudiantes = document.getElementById('nombreEstudiante');
    const listaEstudiantes = document.getElementById('listaEstudiantes');
    const estudiantesSeleccionados = document.getElementById('estudiantesSeleccionados');

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
        actualizarCampoOculto();
    };

    li.appendChild(btnEliminar);
    listaEstudiantes.appendChild(li);
    actualizarCampoOculto();

    selectEstudiantes.value = '';
}

function actualizarCampoOculto() {
    const listaEstudiantes = document.getElementById('listaEstudiantes');
    const estudiantesSeleccionados = document.getElementById('estudiantesSeleccionados');
    const estudiantes = Array.from(listaEstudiantes.children).map(li => li.dataset.id);
    estudiantesSeleccionados.value = JSON.stringify(estudiantes);
}
</script>
@endsection