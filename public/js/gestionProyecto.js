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