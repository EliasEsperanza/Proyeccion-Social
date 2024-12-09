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