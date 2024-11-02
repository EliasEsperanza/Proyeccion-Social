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


document.addEventListener('DOMContentLoaded', function () {
    const activeLink = localStorage.getItem('activeLink');
    if (activeLink) {
        const link = document.querySelector(`#barra-lateral .nav-link[href="${activeLink}"]`);
        if (link) {
            link.classList.add("activo");
        }
    }
});


//proyectos disponibles
document.addEventListener('DOMContentLoaded', function() {
    const paginationItems = document.querySelectorAll('.paginacion .pagina-item');

    paginationItems.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault(); 

            paginationItems.forEach(el => el.classList.remove('activo'));

            this.classList.add('activo');
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
    const rowCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');

    selectAllCheckbox.addEventListener('change', function() {
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
});

