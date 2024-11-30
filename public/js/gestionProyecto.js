function agregarEstudiante() {
    const inputEstudiante = document.getElementById('nombreEstudiante');
    const nombreEstudiante = inputEstudiante.value.trim();

    if (nombreEstudiante) {
        const li = document.createElement('li');
        li.textContent = `• ${nombreEstudiante}`;
        
        document.getElementById('listaEstudiantes').appendChild(li);

        inputEstudiante.value = '';
    } else {
        alert('Por favor, ingrese el nombre del estudiante.');
    }
}


document.addEventListener("DOMContentLoaded", function() {
    // Obtener referencias a los elementos
    const proyectoSelect = document.getElementById("nombre_proyecto");
    const form = document.getElementById("actualizarProyecto");
    const estudiantesInput = document.getElementById("estudiantesSeleccionados");
    const tutorInput = document.getElementById("idTutor");
    const horasRequeridaInput = document.getElementById("horas");
    const nombreProyectoInput = document.getElementById("nombreProyecto");

    // Escuchar el evento submit del formulario
    form.addEventListener("submit", function(event) {
        // Crear un array para recopilar mensajes de error
        const errores = [];

        // Validar cada campo
        if (!nombreProyectoInput.value.trim()) {
            errores.push("El nombre del proyecto es obligatorio.");
        }
        if (!estudiantesInput.value.trim()) {
            errores.push("Debe seleccionar al menos un estudiante.");
        }
        if (!tutorInput.value.trim()) {
            errores.push("Debe seleccionar un tutor.");
        }
        if (!horasRequeridaInput.value.trim()) {
            errores.push("Debe ingresar las horas requeridas.");
        }

        // Si hay errores, prevenir el envío del formulario y mostrar mensajes
        if (errores.length > 0) {
            event.preventDefault();
            alert(errores.join("\n"));
        }
    });

    // Escuchar cambios en el select de proyectos
    proyectoSelect.addEventListener("change", function() {
        const selectedProyectoId = proyectoSelect.value; // Obtener el ID del proyecto seleccionado

        if (selectedProyectoId) {
            // Asignar la URL dinámica y el método POST al formulario
            form.action = `/proyectos/${selectedProyectoId}/gestionActualizar`;
            form.method = "POST"; // Configurar el método como POST
        }
    });
});



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
    console.log(selectedOption.textContent)

    // Evitar duplicados
    if (!selectedStudents.has(studentId) && selectedOption.textContent !== "Seleccionar estudiante") {
        selectedStudents.set(studentId, studentName);
        updateStudentList();
        estudianteSelect.remove(estudianteSelect.selectedIndex);
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
            const li = button.parentElement;
            selectedStudents.delete(studentId);
            updateStudentList();
            // Restaurar la opción al select
            const estudianteSelect = document.getElementById('idEstudiante');
            const newOption = document.createElement('option');
            newOption.value = studentId;
            newOption.textContent = li.textContent;
            estudianteSelect.appendChild(newOption);
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

        // Limpiar opciones del select de proyectosestudianteSelect.remove(estudianteSelect.selectedIndex);
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
window.onload = function() {
    const estudianteSelect = document.getElementById('idEstudiante');
    const selectedOption = estudianteSelect.options[estudianteSelect.selectedIndex];
    console.log(selectedOption.textContent);
    // Verificar si el texto del seleccionado es diferente de 'Seleccionar un estudiante'
    if (selectedOption.textContent !== 'Seleccionar estudiante') {
        // Crear una nueva opción para 'Seleccionar un estudiante' si no existe
        console.log("entro en el if");
        let defaultOption = estudianteSelect.querySelector('option[value=""]');
        if (!defaultOption) {
            defaultOption = document.createElement('option');
            defaultOption.disabled = true;
            defaultOption.value = '';
            defaultOption.textContent = 'Seleccionar un estudiante';
            estudianteSelect.insertBefore(defaultOption, estudianteSelect.firstChild);
        }

        // Mover la selección actual al principio del select
        //estudianteSelect.prepend(selectedOption, estudianteSelect.firstChild);
        //console.log(estudianteSelect.firstChild.textContent);
        // Opcional: Seleccionar automáticamente el nuevo primer elemento
        estudianteSelect.selectedIndex = 0;
    }
};


document.getElementById('fecha_inicio').addEventListener('change', function () {
    const fechaInicio = this.value;
    const fechaFinInput = document.getElementById('fecha_fin');

    if (fechaInicio) {
        const fechaInicioDate = new Date(fechaInicio);
        fechaInicioDate.setMonth(fechaInicioDate.getMonth() + 6);


        const minFechaFin = fechaInicioDate.toISOString().split('T')[0];

        fechaFinInput.min = minFechaFin;

        if (fechaFinInput.value < minFechaFin) {
            fechaFinInput.value = '';
        }
    }
});
