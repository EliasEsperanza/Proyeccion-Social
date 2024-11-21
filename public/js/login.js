document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const emailInput = document.querySelector('#correo');
    const passwordInput = document.querySelector('#contrasena');
    const showPasswordBtn = document.querySelector('#botonMostrarContrasena');
    const passwordIcon = document.querySelector('#iconoMostrarContrasena');

    // Toggle de contraseña
    showPasswordBtn.addEventListener('click', function() {
        const tipo = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = tipo;
        
        passwordIcon.classList.toggle('bi-eye');
        passwordIcon.classList.toggle('bi-eye-slash');
    });

    // Función para mostrar errores
    function showError(message, isToast = true) {
        if (isToast) {
            const toastContainer = document.querySelector('.toast-container') || createToastContainer();
            
            const toastHTML = `
                <div class="toast show mb-2 overflow-hidden border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="d-flex">
                        <div class="toast-body text-bg-danger">
                            <i class="bi bi-exclamation-circle me-2"></i>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            const toast = new bootstrap.Toast(toastContainer.lastElementChild);
            toast.show();

            setTimeout(() => {
                toastContainer.lastElementChild.remove();
            }, 5000);
        } else {
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback d-block';
            feedback.textContent = message;
            return feedback;
        }
    }

    // Crear contenedor de toast
    function createToastContainer() {
        const container = document.createElement('div');
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(container);
        return container;
    }

    // Validación de correo
    function validateEmail(email) {
        return /^[a-zA-Z0-9._%+-]+@example\.com$/.test(email);
    }

    // Validación en tiempo real del correo
    emailInput.addEventListener('input', function() {
        this.classList.remove('is-invalid', 'is-valid');
        const feedback = this.parentNode.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.remove();
        }

        if (this.value.trim() !== '') {
            if (!validateEmail(this.value)) {
                this.classList.add('is-invalid');
                this.parentNode.appendChild(
                    showError('Debe usar un correo institucional (@ues.edu.sv)', false)
                );
            } else {
                this.classList.add('is-valid');
            }
        }
    });

    // Validación en tiempo real de la contraseña
    passwordInput.addEventListener('input', function() {
        this.classList.remove('is-invalid');
        const feedback = this.parentNode.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.remove();
        }
    });

    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let hasErrors = false;

        // Limpiar errores anteriores
        const feedbacks = document.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(feedback => feedback.remove());

        // Validar correo
        if (!emailInput.value.trim()) {
            emailInput.classList.add('is-invalid');
            hasErrors = true;
            emailInput.parentNode.appendChild(
                showError('El correo electrónico es requerido', false)
            );
        } else if (!validateEmail(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            hasErrors = true;
            emailInput.parentNode.appendChild(
                showError('Debe usar un correo institucional (@ues.edu.sv)', false)
            );
        }

        // Validar contraseña
        if (!passwordInput.value.trim()) {
            passwordInput.classList.add('is-invalid');
            hasErrors = true;
            passwordInput.parentNode.appendChild(
                showError('La contraseña es requerida', false)
            );
        }

        if (hasErrors) {
            e.preventDefault(); // Solo prevenir el envío si hay errores
        }
    });
    document.addEventListener('hidden.bs.toast', function(event) {
        event.target.remove();
    });
});