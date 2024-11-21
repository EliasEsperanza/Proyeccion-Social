const tutoresDiv = document.getElementById('tutores-data'); // Div con datos de tutores
const tutores = JSON.parse(tutoresDiv.dataset.tutores); // Parsear los tutores desde el dataset
console.log(tutores)
document.getElementById('seccion_id').addEventListener('change', function () {
    const idSeccion = this.value; // Obtener el ID de la sección seleccionada
    const tutorSelect = document.getElementById('idTutor'); // Select donde se mostrarán los tutores

    // Limpiar las opciones del select
    tutorSelect.innerHTML = '<option selected disabled>Seleccionar tutor</option>';

    // Filtrar tutores que estén asignados a la sección seleccionada
    const tutoresFiltrados = tutores.filter(tutor =>
        tutor.secciones_tutoreadas.some(seccion => seccion.id_seccion == idSeccion) // Verificar si alguna sección coincide
    );

    // Agregar las opciones de tutores al select
    tutoresFiltrados.forEach(tutor => {
        const option = document.createElement('option');
        option.value = tutor.id_usuario; // ID del tutor
        option.textContent = tutor.name; // Nombre del tutor
        tutorSelect.appendChild(option);
    });

    // Mostrar un mensaje si no hay tutores disponibles
    if (tutoresFiltrados.length === 0) {
        const noOption = document.createElement('option');
        noOption.disabled = true;
        noOption.textContent = 'No hay tutores disponibles';
        tutorSelect.appendChild(noOption);
    }
});
