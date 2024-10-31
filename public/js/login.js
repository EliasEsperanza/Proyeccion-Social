const botonMostrarContrasena = document.querySelector('#botonMostrarContrasena');
const campoContrasena = document.querySelector('#contrasena');
const iconoMostrarContrasena = document.querySelector('#iconoMostrarContrasena');

botonMostrarContrasena.addEventListener('click', function () {
  
    const tipo = campoContrasena.getAttribute('type') === 'password' ? 'text' : 'password';
    campoContrasena.setAttribute('type', tipo);
    
    
    iconoMostrarContrasena.classList.toggle('bi-eye');
    iconoMostrarContrasena.classList.toggle('bi-eye-slash');
});
