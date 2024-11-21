document.addEventListener('DOMContentLoaded', function() {
    

    // Checkbox de "Seleccionar Todos"
    const selectAllCheckbox = document.getElementById('selectAll');
    const projectCheckboxes = document.querySelectorAll('.selectProject');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            projectCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    }

    projectCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (!checkbox.checked) {
                selectAllCheckbox.checked = false;
            } else if (Array.from(projectCheckboxes).every(cb => cb.checked)) {
                selectAllCheckbox.checked = true;
            }
        });
    });

    // Filtrar proyectos en la tabla
    const searchInput = document.getElementById('searchInput');
    const projectTableBody = document.getElementById('projectTableBody');
    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase();
        const rows = projectTableBody.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const cells = row.getElementsByTagName('td');
            let match = false;
            
            Array.from(cells).forEach(cell => {
                if (cell.textContent.toLowerCase().includes(filter)) {
                    match = true;
                }
            });

            row.style.display = match ? '' : 'none';
        });
    });
});