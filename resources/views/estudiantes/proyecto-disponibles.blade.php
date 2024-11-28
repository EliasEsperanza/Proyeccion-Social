@extends('layouts.appE')

@section('title', 'Detalles del Proyecto')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/proyecto-disponibleE.css') }}">
@endsection

@section('content')

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session()->has('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('warning') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif



<div class="container py-5">
    <div class="card shadow tarjeta-detalle mx-auto" style="max-width: 800px;">
        <div class="card-body p-4">
            <form action="{{ route('store_solicitud_alumno') }}" method="POST" id="actualizarProyecto">
                @csrf

                <h2 class="titulo-proyecto mb-4 text-center">{{$proyecto->nombre_proyecto }}</h2>
                <p class="descripcion mb-3">
                    <strong>Descripción:</strong> {{ $proyecto->descripcion_proyecto }}
                </p>
                <div class="detalles-proyecto">
                    <p><strong>Horas requeridas:</strong> {{ $proyecto->horas_requeridas }}</p>
                    <p><strong>Ubicación:</strong> {{ $proyecto->lugar }}</p>
                    <p><strong>Sección:</strong>
                        {{ $proyecto->seccion->nombre_seccion ?? 'Sin sección asignada' }}
                    </p>
                    <p><strong>Estado:</strong> {{ $proyecto->estadoo->nombre_estado ?? 'Sin estado definido' }}</p>
                </div>

                <div class="d-flex">
                    <select class="form-select" id="idEstudiante" name="idEstudiante">
                        @foreach ($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id_estudiante }}">
                            {{ $estudiante->usuario->name }}
                        </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-light btn-sm p-2 px-3" id="addStudentBtn">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>

                <!-- Lista para mostrar los estudiantes seleccionados -->
                <ul id="studentList" class="mt-3"></ul>

                <!-- Lista de estudiantes asignados -->
                <ul id="estudiantesList">
                </ul>

                <input type="hidden" id="estudiantesSeleccionados" name="estudiantesSeleccionados" value='[]'>
                <input type="hidden" id="id_proyecto" name="id_proyecto" value='{{$proyecto->id_proyecto}}'>

                <div class="d-flex justify-content-between mt-4">
                    <button class="btn btn-enviar me-2">Enviar solicitud</button>
                    <a href="{{ route('estudiantes.dashboard') }}" class="btn btn-regresar">Regresar</a>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

<script>
    //enviar form
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener referencias a los elementos
        const proyectoSelect = document.getElementById("nombre_proyecto");
        const form = document.getElementById("actualizarProyecto");

        // Escuchar cambios en el select de proyectos
        proyectoSelect.addEventListener("change", function() {
            const selectedProyectoId = proyectoSelect.value; // Obtener el ID del proyecto seleccionado

            if (selectedProyectoId) {
                // Asignar la URL dinámica al atributo action del formulario
                form.action = `/proyectos/${selectedProyectoId}/gestionActualizar`;
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const estudianteSelect = document.getElementById('idEstudiante');
        const addStudentBtn = document.getElementById('addStudentBtn');
        const studentList = document.getElementById('studentList');
        const hiddenInput = document.getElementById('estudiantesSeleccionados');
        const idTutor = document.getElementById('idTutor');

        // Mapa para almacenar estudiantes seleccionados (ID y nombre)
        const selectedStudents = new Map();

        // Evento: Agregar estudiantes seleccionados a la lista
        addStudentBtn.addEventListener('click', function() {
            const selectedOption = estudianteSelect.options[estudianteSelect.selectedIndex];
            const studentId = selectedOption.value;
            const studentName = selectedOption.textContent;

            // Evitar duplicados
            if (!selectedStudents.has(studentId)) {
                selectedStudents.set(studentId, studentName);
                updateStudentList();
            }
        });

        // Función: Actualizar la lista visual y el campo oculto
        function updateStudentList() {
            studentList.innerHTML = "";

            // Iterar sobre los estudiantes seleccionados y renderizar en la lista
            selectedStudents.forEach((name, id) => {
                const listItem = document.createElement('li');
                listItem.className = 'd-flex justify-content-between align-items-center mb-2';

                listItem.innerHTML = `
                    ${name}
                    <button class="btn btn-danger btn-sm" data-id="${id}">
                        <i class="bi bi-trash"></i>
                    </button>
                `;

                studentList.appendChild(listItem);
            });

            // Actualizar el valor del campo oculto con los IDs seleccionados
            hiddenInput.value = JSON.stringify([...selectedStudents.keys()]);

            // Añadir eventos de eliminación a los botones
            studentList.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', function() {
                    const studentId = button.getAttribute('data-id');
                    selectedStudents.delete(studentId);
                    updateStudentList();
                });
            });
        }
    });
</script>