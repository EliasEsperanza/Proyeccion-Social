document.addEventListener("DOMContentLoaded", function () {
    const contenedorCarrusel = document.getElementById("contenedorCarrusel");
    const btnIzquierda = document.getElementById("btnIzquierda");
    const btnDerecha = document.getElementById("btnDerecha");

    const desplazamiento = contenedorCarrusel.offsetWidth / 2; 

    btnIzquierda.addEventListener("click", () => {
        contenedorCarrusel.scrollBy({ left: -desplazamiento, behavior: "smooth" });
    });

    btnDerecha.addEventListener("click", () => {
        contenedorCarrusel.scrollBy({ left: desplazamiento, behavior: "smooth" });
    });
});
