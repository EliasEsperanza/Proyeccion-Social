document.addEventListener('DOMContentLoaded', function () {
    // Formularios
    const passwordForm = document.getElementById('passwordForm');
    const profileForm = document.getElementById('profileForm');
    const currentPasswordInput = document.getElementById('contrasena_actual');
    const newPasswordInput = document.getElementById('nueva_contrasena');
    const confirmPasswordInput = document.getElementById('nueva_contrasena_confirmation');
    const btnAcceptChanges = document.getElementById('btnAcceptChanges');

    // Mostrar/ocultar contraseñas
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const inputId = this.getAttribute('data-target');
            const input = document.getElementById(inputId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        });
    });

    // Mostrar retroalimentación visual de los inputs
    function showInputFeedback(input, isValid, message) {
        const existingFeedback = input.parentElement.parentElement.querySelector('.feedback-message');
        if (existingFeedback) {
            existingFeedback.remove();
        }

        input.classList.remove('is-valid', 'is-invalid');
        input.classList.add(isValid ? 'is-valid' : 'is-invalid');

        if (!isValid && message) {
            const feedbackDiv = document.createElement('div');
            feedbackDiv.className = `feedback-message ${isValid ? 'valid-feedback' : 'invalid-feedback'} d-block`;
            feedbackDiv.textContent = message;
            input.parentElement.parentElement.appendChild(feedbackDiv);
        }
    }

    // Validar nueva contraseña según requisitos
    function validatePassword(password) {
        const requirements = [
            { regex: /.{8,}/, message: 'Al menos 8 caracteres' },
            { regex: /[A-Z]/, message: 'Al menos una mayúscula' },
            { regex: /[a-z]/, message: 'Al menos una minúscula' },
            { regex: /[0-9]/, message: 'Al menos un número' },
            { regex: /[@$!%*?&]/, message: 'Al menos un carácter especial (@$!%*?&)' }
        ];

        return requirements.filter(req => !req.regex.test(password)).map(req => req.message);
    }

    // Validaciones en tiempo real
    currentPasswordInput.addEventListener('input', function () {
        const isValid = this.value.length >= 1;
        showInputFeedback(this, isValid, isValid ? '' : 'La contraseña actual es requerida');
    });

    newPasswordInput.addEventListener('input', function () {
        const failedRequirements = validatePassword(this.value);
        const isValid = failedRequirements.length === 0;

        showInputFeedback(this, isValid, isValid ? '' : `Requisitos faltantes: ${failedRequirements.join(', ')}`);

        if (confirmPasswordInput.value) {
            validatePasswordConfirmation();
        }
    });

    function validatePasswordConfirmation() {
        const isValid = confirmPasswordInput.value === newPasswordInput.value;
        showInputFeedback(confirmPasswordInput, isValid, isValid ? '' : 'Las contraseñas no coinciden');
        return isValid;
    }

    confirmPasswordInput.addEventListener('input', validatePasswordConfirmation);

    // Envío del formulario de contraseña
    passwordForm.addEventListener('submit', function (e) {
        e.preventDefault();
        let isValid = true;

        if (!currentPasswordInput.value) {
            showInputFeedback(currentPasswordInput, false, 'La contraseña actual es requerida');
            isValid = false;
        }

        const failedRequirements = validatePassword(newPasswordInput.value);
        if (failedRequirements.length > 0) {
            showInputFeedback(newPasswordInput, false, `Requisitos faltantes: ${failedRequirements.join(', ')}`);
            isValid = false;
        }

        if (!validatePasswordConfirmation()) {
            isValid = false;
        }

        if (currentPasswordInput.value === newPasswordInput.value) {
            showInputFeedback(newPasswordInput, false, 'La nueva contraseña debe ser diferente a la actual');
            isValid = false;
        }

        if (isValid) {
            Swal.fire({
                title: '¿Estás seguro de que quieres actualizar la contraseña?',
                icon: 'warning',
                iconColor: '#800000',
                showCancelButton: true,
                confirmButtonText: 'Sí, actualizar',
                confirmButtonColor: '#800000',
                cancelButtonColor: '#C7C8CC',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    passwordForm.submit();
                    Swal.fire({
                        title: "Actualizado!",
                        text: "La contraseña fue actualizada con éxito!",
                        icon: "success",
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#800000'
                    });
                }
            });
        }
    });

    // Validaciones para formulario de perfil
    const nombreInput = document.getElementById('nombre');

    function validarNombre(nombre) {
        if (nombre.length > 50) {
            return 'El nombre no puede tener más de 50 caracteres';
        }

        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/.test(nombre)) {
            return 'Solo se permiten letras';
        }

        return '';
    }

    nombreInput.addEventListener('input', function () {
        const nombre = this.value;
        const error = validarNombre(nombre);

        let feedbackDiv = this.parentElement.querySelector('.invalid-feedback');
        if (!feedbackDiv) {
            feedbackDiv = document.createElement('div');
            feedbackDiv.className = 'invalid-feedback';
            this.parentElement.appendChild(feedbackDiv);
        }

        if (error) {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
            feedbackDiv.textContent = error;
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
            feedbackDiv.textContent = '';
        }

        if (this.value.length > 14) {
            this.value = this.value.slice(0, 14);
        }
    });

    nombreInput.addEventListener('keypress', function (e) {
        const char = String.fromCharCode(e.charCode);
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/.test(char)) {
            e.preventDefault();
        }
    });

    profileForm.addEventListener('submit', function (e) {
        const nombre = nombreInput.value.trim();
        const error = validarNombre(nombre);

        if (error) {
            e.preventDefault();
            nombreInput.classList.add('is-invalid');
            let feedbackDiv = nombreInput.parentElement.querySelector('.invalid-feedback');
            if (!feedbackDiv) {
                feedbackDiv = document.createElement('div');
                feedbackDiv.className = 'invalid-feedback';
                nombreInput.parentElement.appendChild(feedbackDiv);
            }
            feedbackDiv.textContent = error;
        } else {
            Swal.fire({
                title: '¿Estás seguro de que quieres guardar los cambios?',
                icon: 'warning',
                iconColor: '#800000',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                confirmButtonColor: '#800000',
                cancelButtonColor: '#C7C8CC',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    profileForm.submit();
                    Swal.fire({
                        title: "Actualizado!",
                        text: "Los datos del perfil se actualizaron correctamente!",
                        icon: "success",
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#800000'
                    });
                }
            });
        }
    });
});
