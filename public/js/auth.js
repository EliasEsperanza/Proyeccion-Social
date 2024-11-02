const togglePassword1 = document.getElementById('togglePassword1');
const passwordInput1 = document.getElementById('nueva_contrasena');

const togglePassword2 = document.getElementById('togglePassword2');
const passwordInput2 = document.getElementById('confirmar_contrasena');

function togglePassword(passwordInput, togglePassword) {
    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    togglePassword.classList.toggle('bi-eye');
    togglePassword.classList.toggle('bi-eye-slash');
}

togglePassword1.addEventListener('click', () => togglePassword(passwordInput1, togglePassword1));
togglePassword2.addEventListener('click', () => togglePassword(passwordInput2, togglePassword2));