    // Espera 3 segundos antes de desvanecer las alertas
    setTimeout(() => {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.classList.remove('show');

            // Opcional: remueve el elemento del DOM tras completar la animación
            alert.addEventListener('transitionend', () => {
                alert.remove();
            });
        });
    }, 3000);