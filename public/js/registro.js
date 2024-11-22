document.addEventListener('DOMContentLoaded', function() {
    // Elementos del formulario
    const form = document.querySelector('form');
    const nombreInput = document.getElementById('nombre');
    const emailInput = document.getElementById('correo');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmarContrasena');
    const departamentoSelect = document.getElementById('id_seccion');

    // Mostrar/Ocultar contraseña
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const campoId = this.getAttribute('data-campo');
            const input = document.getElementById(campoId === 'contrasena' ? 'password' : 'confirmarContrasena');
            const icon = this.querySelector('i');
            
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    });

    // Función para mostrar feedback
    function showFeedback(input, isValid, message) {
        input.classList.remove('is-invalid', 'is-valid');
        let feedbackDiv = input.parentElement.querySelector('.invalid-feedback');
        
        if (!isValid) {
            input.classList.add('is-invalid');
            if (!feedbackDiv) {
                feedbackDiv = document.createElement('div');
                feedbackDiv.className = 'invalid-feedback';
                input.parentElement.appendChild(feedbackDiv);
            }
            feedbackDiv.textContent = message;
        } else {
            input.classList.add('is-valid');
            if (feedbackDiv) {
                feedbackDiv.remove();
            }
        }
    }

    // Validación de nombre (solo letras)
    nombreInput.addEventListener('input', function() {
        const valor = this.value.trim();
        const soloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/.test(valor);
        
        if (!soloLetras) {
            showFeedback(this, false, 'El nombre solo puede contener letras');
        } else if (valor.length === 0) {
            showFeedback(this, false, 'El nombre es obligatorio');
        } else {
            showFeedback(this, true);
        }
    });

    // Prevenir caracteres no permitidos en el nombre
    nombreInput.addEventListener('keypress', function(e) {
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/.test(e.key)) {
            e.preventDefault();
        }
    });

    // Validación de correo institucional
    emailInput.addEventListener('input', function() {
        const valor = this.value.trim();
        //const esCorreoUES = /^[a-zA-Z0-9._%+-]+@ues\.edu\.sv$/.test(valor);
        const esCorreoUES = /^[a-zA-Z0-9._%+-]+@example\.com$/.test(valor);
        if (!valor) {
            showFeedback(this, false, 'El correo es obligatorio');
        } else if (!esCorreoUES) {
            showFeedback(this, false, 'Debe usar un correo institucional (@ues.edu.sv)');
        } else {
            showFeedback(this, true);
        }
    });

    // Validación de contraseña
    passwordInput.addEventListener('input', function() {
        const valor = this.value;
        const tieneMinuscula = /[a-z]/.test(valor);
        const tieneMayuscula = /[A-Z]/.test(valor);
        const tieneNumero = /\d/.test(valor);
        const tieneEspecial = /[@$!%*?&#]/.test(valor);
        const longitudValida = valor.length >= 8;
        
        const esValida = tieneMinuscula && tieneMayuscula && tieneNumero && 
                        tieneEspecial && longitudValida;
        
        if (!esValida) {
            showFeedback(this, false, 'La contraseña debe cumplir con todos los requisitos');
        } else {
            showFeedback(this, true);
        }

        if (confirmPasswordInput.value) {
            validarConfirmacion();
        }
    });

    // Validación de confirmación de contraseña
    function validarConfirmacion() {
        const coinciden = confirmPasswordInput.value === passwordInput.value;
        showFeedback(confirmPasswordInput, coinciden, 
            coinciden ? '' : 'Las contraseñas no coinciden');
        return coinciden;
    }

    confirmPasswordInput.addEventListener('input', validarConfirmacion);

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let hasErrors = false;

        // Validar nombre
        if (!nombreInput.value.trim() || !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreInput.value)) {
            showFeedback(nombreInput, false, 'Ingrese un nombre válido');
            hasErrors = true;
        }

        // Validar correo
        if (!emailInput.value.trim() || !/@example\.com$/.test(emailInput.value)) {
            showFeedback(emailInput, false, 'Ingrese un correo institucional válido');
            hasErrors = true;
        }

        // Validar contraseña
        if (!passwordInput.value || passwordInput.value.length < 8) {
            showFeedback(passwordInput, false, 'Ingrese una contraseña válida');
            hasErrors = true;
        }

        // Validar confirmación
        if (!validarConfirmacion()) {
            hasErrors = true;
        }

        // Validar departamento
        if (!departamentoSelect.value) {
            showFeedback(departamentoSelect, false, 'Seleccione un departamento');
            hasErrors = true;
        }

        if (!hasErrors) {
            this.submit();
        }
    });
});