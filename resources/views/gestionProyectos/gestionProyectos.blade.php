@extends('layouts.app')

@section('title', 'Gestión de Proyectos')

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

<div class="container ">

    <div class="container">
        <h1 class="mb-4">Gestión de Proyectos</h1>

        

        <div class="card w-100">
            <div class="card-body">
                <form action="" method="POST" id="actualizarProyecto">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Sección o Departamento</label>
                        <div class="input-group mb-3">
                            <select name="seccion_id" class="form-select @error('departamento') is-invalid @enderror" id="seccion_id">
                                <option selected disabled>Seleccionar departamento</option>
                                @foreach($secciones as $seccion)
                                <option value="{{$seccion->id_seccion}}">
                                    {{$seccion->nombre_seccion}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Sección de Estudiantes -->
        <div class="mb-3">
            <label class="form-label">Estudiantes</label>
            
            <div class="d-flex">
                <select class="form-select" id="idEstudiante" name="idEstudiante" disabled>
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
        </div>

                    <div class="mb-3">
                        <label for="proyectosDisponibles" class="form-label">Proyectos Disponibles</label>
                        <select class="form-select" id="nombre_proyecto" name="nombre_proyecto" disabled>
                            <option selected disabled>Seleccione un proyecto</option>
                            @foreach($proyectos as $proyecto)
                            <option value="{{$proyecto->id_proyecto}}">{{$proyecto->nombre_proyecto}}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Campo oculto para almacenar estudiantes seleccionados -->
                    <input type="hidden" id="estudiantesSeleccionados" name="estudiantes">

                    <ul id="listaEstudiantes" class="list-unstyled"></ul>

                    <div class="mb-3">
                        <label for="tutor" class="form-label">Tutor</label>
                        <select class="form-control" id="idTutor" name="idTutor" disabled>
                            <option selected disabled>Seleccione un tutor</option>
                            @foreach($tutores as $tutor)
                            <option value="{{$tutor->id_usuario}}">{{$tutor->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="lugar" name="lugar" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="horas" class="form-label">Horas Requeridas</label>
                        <input type="text" class="form-control" id="horas" name="horas" >
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fechaFin" class="form-label">Fecha de Finalización</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" readonly>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            @foreach ($estados as $estado)
                            <option value="{{ $estado->id_estado }}">
                                {{ $estado->nombre_estado }}
                            </option>
                            @endforeach
                        </select>
                        
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-gestion fw-bold">Asignar Proyecto</button>
                </form>

            </div>
        </div>
    </div>

    <div id="tutores-data" data-tutores='@json($tutores)'></div>
    <div id="proyectos-data" data-proyectos='@json($proyectos)'></div>
    <div id="estudiantes-data" data-estudiantes='@json($estudiantes)'></div>

    <script src="{{ asset('js/filtrarTutor.js') }}"></script>
    <script src="{{ asset('js/filtrarEstudiantes.js') }}"></script>
    <script src="{{ asset('js/gestionProyecto.js') }}"></script>

    <script>
        //enviar form
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener referencias a los elementos
            const proyectoSelect = document.getElementById("nombre_proyecto");
            const form = document.getElementById("actualizarProyecto");
            const estudiantesInput = document.getElementById("estudiantesSeleccionados");

            // Escuchar cambios en el select de proyectos
            proyectoSelect.addEventListener("change", function() {
                const selectedProyectoId = proyectoSelect.value; // Obtener el ID del proyecto seleccionado

                if (selectedProyectoId) {
                    // Asignar la URL dinámica al atributo action del formulario
                    form.action = `/proyectos/${selectedProyectoId}/gestionActualizar`;
                }
            });
            form.addEventListener("submit", function(event) {
                // Validar lista de estudiantes
                if (!estudiantesInput.value) {
                    event.preventDefault();
                    alert("Por favor, agregue estudiantes al proyecto.");
                }
            });
        });
    </script>

<script>

    const estudianteSelect = document.getElementById('idEstudiante');
    const addStudentBtn = document.getElementById('addStudentBtn');
    const studentList = document.getElementById('studentList');
    const hiddenInput = document.getElementById('estudiantesSeleccionados');
    // Mapa para almacenar estudiantes seleccionados (ID y nombre)
    const selectedStudents = new Map();

    // Evento: Agregar estudiantes seleccionados a la lista
    addStudentBtn.addEventListener('click', function () {
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
        // Limpiar la lista visual
        studentList.innerHTML = "";
        console.log(selectedStudents);
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
            button.addEventListener('click', function () {
                const studentId = button.getAttribute('data-id');
                selectedStudents.delete(studentId);
                updateStudentList();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const seccionSelect = document.getElementById('seccion_id');
        const proyectoSelect = document.getElementById('nombre_proyecto');
        const idTutor = document.getElementById('idTutor');

        // Inicialmente, deshabilitar selectores dependientes
        proyectoSelect.disabled = true;
        estudianteSelect.disabled = true;
        idTutor.disabled = true;
        addStudentBtn.disabled = true;


        // Evento: Habilitar selectores al seleccionar una sección
        seccionSelect.addEventListener('change', function () {
            const seccionId = this.value;

            // Habilitar selectores dependientes
            proyectoSelect.disabled = false;
            estudianteSelect.disabled = false;
            idTutor.disabled = false;
            addStudentBtn.disabled = false;

            // Limpiar opciones del select de proyectos
            proyectoSelect.innerHTML = '<option selected disabled>Seleccionar proyecto</option>';

            // Cargar proyectos por sección
            fetch(`/proyectos-por-seccion/${seccionId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(proyecto => {
                        const option = document.createElement('option');
                        option.value = proyecto.id_proyecto;
                        option.textContent = proyecto.nombre_proyecto;
                        proyectoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar proyectos:', error));
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const proyectoSelect = document.getElementById('nombre_proyecto');
    const ubicacionInput = document.getElementById('lugar');
    const fechaInicioInput = document.getElementById('fecha_inicio');
    const fechaFinInput = document.getElementById('fecha_fin');

    proyectoSelect.addEventListener('change', function () {
        const proyectoId = this.value;

        if (proyectoId) {
            fetch(`/proyectos/${proyectoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Rellenar los campos con los datos del proyecto
                    ubicacionInput.value = data.ubicacion || '';
                    fechaInicioInput.value = data.fecha_inicio || '';
                    fechaFinInput.value = data.fecha_fin || '';
                    // Verificar si hay estudiantes y procesarlos
                    if (data.estudiantes != null) {
                        data.estudiantes.forEach(estudiante => {
                            const id = String(estudiante.id_estudiante); // Convertir a número
                            selectedStudents.set(id, estudiante.name);
                            updateStudentList();
                        });
                    }
                })
                .catch(error => console.error('Error al obtener los detalles del proyecto:', error));
        }
    });
});

</script>

    @endsection