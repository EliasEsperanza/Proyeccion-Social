document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('passwordForm');
    const currentPasswordInput = document.getElementById('contrasena_actual');
    const newPasswordInput = document.getElementById('nueva_contrasena');
    const confirmPasswordInput = document.getElementById('nueva_contrasena_confirmation');
    
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
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

    function showInputFeedback(input, isValid, message) {
        // Remover feedback anterior
        const existingFeedback = input.parentElement.parentElement.querySelector('.feedback-message');
        if (existingFeedback) {
            existingFeedback.remove();
        }

        input.classList.remove('is-valid', 'is-invalid');
        input.classList.add(isValid ? 'is-valid' : 'is-invalid');

        if (!isValid && message) {
            // Crear nuevo feedback
            const feedbackDiv = document.createElement('div');
            feedbackDiv.className = `feedback-message ${isValid ? 'valid-feedback' : 'invalid-feedback'} d-block`;
            feedbackDiv.textContent = message;
            input.parentElement.parentElement.appendChild(feedbackDiv);
        }
    }

    function validatePassword(password) {
        const requirements = [
            { regex: /.{8,}/, message: 'Al menos 8 caracteres' },
            { regex: /[A-Z]/, message: 'Al menos una mayúscula' },
            { regex: /[a-z]/, message: 'Al menos una minúscula' },
            { regex: /[0-9]/, message: 'Al menos un número' },
            { regex: /[@$!%*?&]/, message: 'Al menos un carácter especial (@$!%*?&)' }
        ];

        const failedRequirements = requirements
            .filter(req => !req.regex.test(password))
            .map(req => req.message);

        return failedRequirements;
    }

    currentPasswordInput.addEventListener('input', function() {
        const isValid = this.value.length >= 1;
        showInputFeedback(this, isValid, isValid ? '' : 'La contraseña actual es requerida');
    });

    newPasswordInput.addEventListener('input', function() {
        const failedRequirements = validatePassword(this.value);
        const isValid = failedRequirements.length === 0;
        
        if (!isValid) {
            const message = failedRequirements.join(', ');
            showInputFeedback(this, false, `Requisitos faltantes: ${message}`);
        } else {
            showInputFeedback(this, true);
        }

        // Validar confirmación si ya hay algo escrito
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

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Validar contraseña actual
        if (!currentPasswordInput.value) {
            showInputFeedback(currentPasswordInput, false, 'La contraseña actual es requerida');
            isValid = false;
        }

        // Validar nueva contraseña
        const failedRequirements = validatePassword(newPasswordInput.value);
        if (failedRequirements.length > 0) {
            showInputFeedback(newPasswordInput, false, `Requisitos faltantes: ${failedRequirements.join(', ')}`);
            isValid = false;
        }

        // Validar confirmación de contraseña
        if (!validatePasswordConfirmation()) {
            isValid = false;
        }

        // Validar que la nueva contraseña sea diferente a la actual
        if (currentPasswordInput.value === newPasswordInput.value) {
            showInputFeedback(newPasswordInput, false, 'La nueva contraseña debe ser diferente a la actual');
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const nombreInput = document.getElementById('nombre');
        const form = document.querySelector('form');
    
        function validarNombre(nombre) {
            if (nombre.length > 28) {
                return 'El nombre no puede tener más de 28 caracteres';
            }
    
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/.test(nombre)) {
                return 'Solo se permiten letras';
            }
    
            return ''; // Sin errores
        }
    
        // Validación en tiempo real
        nombreInput.addEventListener('input', function() {
            const nombre = this.value;
            const error = validarNombre(nombre);
            
            // Mostrar/ocultar mensaje de error
            let feedbackDiv = this.parentElement.querySelector('.invalid-feedback');
            if (!feedbackDiv) {
                feedbackDiv = document.createElement('div');
                feedbackDiv.className = 'invalid-feedback';
                this.parentElement.appendChild(feedbackDiv);
            }
    
            // Actualizar clases y mensaje
            if (error) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                feedbackDiv.textContent = error;
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                feedbackDiv.textContent = '';
            }
    
            // Limitar a 14 caracteres
            if (this.value.length > 14) {
                this.value = this.value.slice(0, 14);
            }
        });
    
        // Prevenir caracteres no permitidos
        nombreInput.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.charCode);
            // Solo permitir letras, espacios y teclas de control
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/.test(char)) {
                e.preventDefault();
            }
        });
    
        // Validación al enviar el formulario
        form.addEventListener('submit', function(e) {
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
            }
        });
    });
});