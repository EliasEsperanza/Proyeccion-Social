const estudiantesDiv = document.getElementById('estudiantes-data');
const estudiantes = JSON.parse(estudiantesDiv.dataset.estudiantes);

document.getElementById('seccion_id').addEventListener('change', function () {
    const idSeccion = this.value; 
    const estudiantesSelect = document.getElementById('idEstudiante'); 

    estudiantesSelect.innerHTML = '<option selected disabled>Seleccionar estudiante</option>';

    const estudiantesFiltrados = estudiantes.filter(estudiante => estudiante.id_seccion == idSeccion);

    estudiantesFiltrados.forEach(estudiante => {
        const option = document.createElement('option');
        option.value = estudiante.id_estudiante;
        option.textContent = estudiante.usuario.name;
        estudiantesSelect.appendChild(option);
    });

    if (estudiantesFiltrados.length === 0) {
        const noOption = document.createElement('option');
        noOption.disabled = true;
        noOption.textContent = 'No hay estudiantes disponibles';
        estudiantesSelect.appendChild(noOption);
    }
});