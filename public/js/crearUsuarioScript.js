//Script para manejar el comportamiento -->

document.getElementById('crearUsuarioForm').addEventListener('submit', async function (e) {
        e.preventDefault(); // Evita el envío normal del formulario

        const form = e.target;
        const rol = document.getElementById('rol').value;
        const submitButton = document.getElementById('submitButton');

        // Deshabilitar botón y mostrar indicador de carga
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Procesando...
        `;

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                // Mostrar mensaje de éxito
                const successMessage = document.getElementById('successMessage');
                successMessage.classList.remove('d-none');
                setTimeout(() => {
                    successMessage.classList.add('d-none');

                    // Mostrar confirmación para crear otro usuario
                    if (rol === 'estudiante') {
                        const confirmCreateAnother = confirm('¿Desea crear otro estudiante?');
                        if (confirmCreateAnother) {
                            form.reset(); // Limpia el formulario
                        } else {
                            window.location.href = '{{ route("dashboard") }}'; // Redirige al dashboard
                        }
                    } else {
                        window.location.href = '{{ route("dashboard") }}'; // Redirige al dashboard para otros roles
                    }
                }, 2000); // Espera 2 segundos antes de mostrar la confirmación
            } else {
                const errorText = await response.text();
                console.error('Error en la respuesta:', errorText);
                alert('Hubo un problema al crear el usuario. Inténtalo nuevamente.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Ocurrió un error. Por favor, inténtalo más tarde.');
        } finally {
            // Rehabilitar botón y restaurar texto
            submitButton.disabled = false;
            submitButton.innerHTML = 'Crear Usuario';
        }
    });