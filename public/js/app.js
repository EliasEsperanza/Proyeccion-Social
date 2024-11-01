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
}
