const botonToggleSuperior = document.getElementById("boton-toggle-superior");
const barraLateral = document.getElementById("barra-lateral");

function alternarSidebar() {
    if (window.innerWidth >= 768) {
        barraLateral.classList.toggle("oculto");
    } else {
        barraLateral.classList.toggle("visible");
    }
}

botonToggleSuperior.addEventListener("click", alternarSidebar);

function establecerActivo(elemento) {
    const enlaces = document.querySelectorAll("#barra-lateral .nav-link");
    enlaces.forEach(enlace => enlace.classList.remove("activo"));
    elemento.classList.add("activo");
    localStorage.setItem('activeLink', elemento.getAttribute('href')); 
}


document.addEventListener("DOMContentLoaded", function () {
    const enlaces = document.querySelectorAll("#barra-lateral .nav-link"); 
    const currentUrl = window.location.origin + window.location.pathname; 
    const perfilUrl = "{{ route('perfil_usuario') }}";

    function desactivarTodos() {
        enlaces.forEach((enlace) => enlace.classList.remove("activo"));
    }

    function establecerEnlaceActivo() {
        desactivarTodos(); 
        if (currentUrl === perfilUrl) {
            return; 
        }

        const enlaceActivo = Array.from(enlaces).find((enlace) => enlace.href === currentUrl);
        if (enlaceActivo) {
            enlaceActivo.classList.add("activo");
        }
    }

    enlaces.forEach((enlace) => {
        enlace.addEventListener("click", function () {
            desactivarTodos();
            this.classList.add("activo");
        });
    });

    establecerEnlaceActivo();
});


document.addEventListener("DOMContentLoaded", function () {
    const enlaces = document.querySelectorAll("#barra-lateral .nav-link"); 
    const currentUrl = window.location.origin + window.location.pathname; 
    const perfilUrl = "{{ route('perfil_usuario') }}";

    function desactivarTodos() {
        enlaces.forEach((enlace) => enlace.classList.remove("activo"));
    }

    function establecerEnlaceActivo() {
        desactivarTodos(); 
        if (currentUrl === perfilUrl) {
            return; 
        }

        const enlaceActivo = Array.from(enlaces).find((enlace) => enlace.href === currentUrl);
        if (enlaceActivo) {
            enlaceActivo.classList.add("activo");
        }
    }

    enlaces.forEach((enlace) => {
        enlace.addEventListener("click", function () {
            desactivarTodos();
            this.classList.add("activo");
        });
    });

    establecerEnlaceActivo();
});
