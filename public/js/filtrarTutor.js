document.addEventListener('DOMContentLoaded', function () {
    const seccionSelect = document.getElementById('seccion_id');
    const tutorSelect = document.getElementById('tutor');
    const tutoresDiv = document.getElementById('tutores-data');

    try {
        const tutores = JSON.parse(tutoresDiv.dataset.tutores);
        console.log('Tutores cargados:', tutores);

        seccionSelect.addEventListener('change', function () {
            const idSeccion = this.value;
            console.log('Sección seleccionada para tutores:', idSeccion);

            // Limpiar el select de tutores
            tutorSelect.innerHTML = '<option selected disabled>Seleccione un tutor</option>';

            // Filtrar tutores por sección
            const tutoresFiltrados = tutores.filter(tutor => tutor.id_seccion == idSeccion);
            console.log('Tutores filtrados:', tutoresFiltrados);

            // Agregar opciones al select de tutores
            if (tutoresFiltrados.length > 0) {
                tutoresFiltrados.forEach(tutor => {
                    const option = document.createElement('option');
                    option.value = tutor.id_tutor;
                    option.textContent = tutor.name;
                    tutorSelect.appendChild(option);
                });
            } else {
                const noOption = document.createElement('option');
                noOption.disabled = true;
                noOption.textContent = 'No hay tutores disponibles';
                tutorSelect.appendChild(noOption);
            }
        });
    } catch (error) {
        console.error('Error procesando los tutores:', error);
    }
});
