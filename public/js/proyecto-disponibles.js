
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
