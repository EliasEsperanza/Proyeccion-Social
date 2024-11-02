document.querySelectorAll('[id^="botonMostrarContrasena"]').forEach((boton) => {
    boton.addEventListener('click', function () {
        const campoId = this.getAttribute('data-campo');
        const iconoId = this.getAttribute('data-icono');
        const campo = document.getElementById(campoId);
        const icono = document.getElementById(iconoId);

        campo.type = campo.type === 'password' ? 'text' : 'password';
        
        icono.classList.toggle('bi-eye');
        icono.classList.toggle('bi-eye-slash');
    });
});
