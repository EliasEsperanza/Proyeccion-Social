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

        <!-- Sección de Estudiantes -->
        <div class="mb-3">
            <label class="form-label">Estudiantes</label>
            
            <!-- Formulario para agregar estudiantes -->
            <form action="" method="POST" class="d-flex mb-3" id="agregarEstudiantes">
                @csrf

            </form>
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
        </div>
    
        <div class="card w-100">
            <div class="card-body">
            <form action="" method="POST" id="actualizarProyecto">
                    @csrf
            <div class="mb-3">
                <label for="proyectosDisponibles" class="form-label">Proyectos Disponibles</label>
                <select class="form-select" id="nombre_proyecto" name="nombre_proyecto">
                    <option selected disabled>Seleccione un proyecto</option>
                    @foreach($proyectos as $proyecto)
                    <option value="{{$proyecto->id_proyecto}}">{{$proyecto->nombre_proyecto}}</option>
                    @endforeach
                </select>
            </div>
            
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

            <!-- Campo oculto para almacenar estudiantes seleccionados -->
            <input type="hidden" id="estudiantesSeleccionados" name="estudiantes">

            <ul id="listaEstudiantes" class="list-unstyled"></ul>

            <div class="mb-3">
                <label for="tutor" class="form-label">Tutor</label>
                <select class="form-control" id="idTutor" name="idTutor">
                    <option selected disabled>Seleccione un tutor</option>
                    @foreach($tutores as $tutor)
                        <option value="{{$tutor->id_usuario}}">{{$tutor->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="lugar" name="lugar">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" >
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fechaFin" class="form-label">Fecha de Finalización</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" >
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
    

<script src="{{ asset('js/gestionProyecto.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener referencias a los elementos
        const proyectoSelect = document.getElementById("nombre_proyecto");
        const form = document.getElementById("actualizarProyecto");

        // Escuchar cambios en el select de proyectos
        proyectoSelect.addEventListener("change", function () {
            const selectedProyectoId = proyectoSelect.value; // Obtener el ID del proyecto seleccionado

            if (selectedProyectoId) {
                // Asignar la URL dinámica al atributo action del formulario
                form.action = `/proyectos/${selectedProyectoId}/gestionActualizar`;
            }
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const selectEstudiante = document.getElementById("idEstudiante");
    const selectProyecto = document.getElementById("nombre_proyecto");
    const addButton = document.getElementById("addStudentBtn");
    const studentList = document.getElementById("studentList");

    // Lista para almacenar estudiantes seleccionados
    const selectedStudents = new Map();

    // Evento para añadir estudiante a la lista
    addButton.addEventListener("click", () => {
        const proyectoSeleccionado = selectProyecto.value;

        // Verificar si hay un proyecto seleccionado
        if (!proyectoSeleccionado || proyectoSeleccionado === "Seleccione un proyecto") {
            alert("Por favor, seleccione un proyecto antes de añadir estudiantes.");
            return;
        }

        const studentId = selectEstudiante.value;
        const studentName = selectEstudiante.options[selectEstudiante.selectedIndex].text;

        // Verificar si ya está en la lista
        if (selectedStudents.has(studentId)) {
            alert("Este estudiante ya está en la lista.");
            return;
        }

        // Añadir a la lista interna
        selectedStudents.set(studentId, studentName);

        // Actualizar la lista visual
        updateStudentList();
    });

    // Función para actualizar la lista de estudiantes visualmente
    function updateStudentList() {
        // Limpiar el listado actual
        studentList.innerHTML = "";

        // Iterar sobre los estudiantes seleccionados y mostrarlos
        selectedStudents.forEach((name, id) => {
            const listItem = document.createElement("li");
            listItem.className = "d-flex justify-content-between align-items-center mb-2";

            listItem.innerHTML = `
                ${name}
                <button class="btn btn-danger btn-sm" data-id="${id}">
                    <i class="bi bi-trash"></i>
                </button>
            `;

            studentList.appendChild(listItem);
        });

        // Añadir eventos de eliminación a los botones
        studentList.querySelectorAll("button").forEach(button => {
            button.addEventListener("click", () => {
                const studentId = button.getAttribute("data-id");
                selectedStudents.delete(studentId);
                updateStudentList();
            });
        });
    }
});
</script>

@endsection