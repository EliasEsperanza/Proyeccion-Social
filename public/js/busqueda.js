document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const resultsContainer = document.querySelector('tbody');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    searchInput.addEventListener('input', function() {
        const query = searchInput.value;

        if (query.length > 0) {
            fetch(`/usuarios/buscar?search=${query}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = '';

                data.forEach(usuario => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><input type="checkbox" name="users[]" value="${usuario.id_usuario}"></td>
                        <td>${usuario.id_usuario}</td>
                        <td>${usuario.name}</td>
                        <td>${usuario.email}</td>
                        <td>${usuario.role ?? 'Sin rol'}</td>
                        <td>${usuario.seccion ?? 'Sin sección'}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/usuarios/editar/${usuario.id_usuario}" class="btn btn-light btn-sm p-2 px-3"><i class="bi bi-pencil text-warning"></i></a>
                                <form method="POST" action="/usuarios/eliminar/${usuario.id_usuario}" style="display: inline-block;">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-light btn-sm p-2 px-3" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </form>
                                <a href="/perfil/${usuario.id_usuario}" class="btn btn-light btn-sm p-2 px-3"><i class="bi bi-eye text-muted"></i></a>
                            </div>
                        </td>
                    `;
                    resultsContainer.appendChild(row);
                });
            });
        } else {
            // Si el campo de búsqueda está vacío, recargar la página
            window.location.reload();
        }
    });
});