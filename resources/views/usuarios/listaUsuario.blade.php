@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container-fluid mt-1">
    <h2 class="text-start mb-4">Lista de Usuarios</h2>

    <div class="card shadow-sm p-4" style="border-radius: 12px; overflow: hidden;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group ms-auto w-25">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search text-secondary"></i>
                </span>
                <input type="text" class="form-control border-0" placeholder="Buscar">
                <span class="input-group-text bg-light border-0">
                    <i class="fas fa-filter custom-filter-icon"></i>
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col"><input type="checkbox"></th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo Electrónico</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Sección/Departamento</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Elian Francisco</td>
                        <td>tp20007@ues.edu.sv</td>
                        <td>Coordinador</td>
                        <td>Sistemas Informáticos</td>
                        <td>
                            <a href="#" class="text-warning me-3"><i class="bi bi-pencil"></i> Editar</a>
                            <a href="#" class="text-danger"><i class="bi bi-trash"></i> Eliminar</a>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Kevin Nathanael</td>
                        <td>gp22006@ues.edu.sv</td>
                        <td>Tutor</td>
                        <td>Sistemas Informáticos</td>
                        <td>
                            <a href="#" class="text-warning me-3"><i class="bi bi-pencil"></i> Editar</a>
                            <a href="#" class="text-danger"><i class="bi bi-trash"></i> Eliminar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <p class="mb-0">Mostrando 1 a 10 de 50 resultados</p>
            
            <div class="d-flex align-items-center">
                <select class="form-select form-select-sm w-auto">
                    <option>10</option>
                    <option>20</option>
                    <option>50</option>
                </select>
                <span class="ms-2">por página</span>
            </div>
            
            <div class="rounded-pagination-wrapper" id="paginationWrapper">
    <div class="pagination-container">
        <nav aria-label="Navegación de página">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item" data-page="1">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item" data-page="2"><a class="page-link" href="#">2</a></li>
                <li class="page-item" data-page="3"><a class="page-link" href="#">3</a></li>
                <li class="page-item" data-page="4"><a class="page-link" href="#">4</a></li>
                <li class="page-item" data-page="5"><a class="page-link" href="#">5</a></li>
                <li class="page-item" data-page="next">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&rsaquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
        </div>
    </div> 
</div>
@endsection
