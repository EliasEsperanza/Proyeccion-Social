@extends('layouts.appE')

@section('title', 'Solicitud de Proyecto')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/publiE.css') }}">

@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-2"><strong>Solicitud de proyecto</strong></h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form>
                <div class="mb-4">
                    <label for="nombreProyecto" class="form-label">Nombre del Proyecto</label>
                    <input type="text" class="form-control" id="nombreProyecto" placeholder="Nombre del Proyecto">
                </div>
                <select class="form-select" id="nombreEstudiante" name="idEstudiante">
                    @foreach ($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id_estudiante }}">
                            {{ $estudiante->usuario->name }}
                        </option>
                    @endforeach
                </select>                
                <button type="button" class="btn btn-light btn-sm p-2 px-3" onclick="agregarEstudiante()">
                    <i class="bi bi-plus"></i>
                </button>
                <ul id="listaEstudiantes" class="list-unstyled"></ul>


                <div class="mb-5">
                    <label for="descripcion" class="form-label">Descripción del proyecto</label>
                    <textarea class="form-control" id="descripcion" rows="4"
                        placeholder="Descripción del proyecto"></textarea>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 mb-4">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" placeholder="Ubicación">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                        <input type="date" class="form-control" id="fechaInicio">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label for="fechaFin" class="form-label">Fecha de finalización</label>
                        <input type="date" class="form-control" id="fechaFin">
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
    ClassicEditor
        .create(document.querySelector('#descripcion'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
            language: 'es'
        })
        .catch(error => {
            console.error(error);
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
    btnEliminar.className = 'btn btn-danger btn-sm ms-2 bi bi-trash';
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
</script>
@endsection