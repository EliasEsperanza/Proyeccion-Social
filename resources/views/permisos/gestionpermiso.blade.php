@extends('layouts.app')

@section('title', 'Gestion de Permisos')

@section('content')

<div class="container mt-4">
                <!-- Formulario para crear nuevo permiso -->
                <h2>Crear nuevo permiso</h2>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Detalles del nuevo permiso</h5>
                        <p class="text-muted">Defina los nuevos permisos</p>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3 m-1">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nuevo permiso">
                            </div>
                            <button type="submit" class="btn btn-yei">Crear nuevo permiso</button>
                        </form>
                    </div>
                </div>

                <!-- Tabla de permisos existentes -->
    <h4 class="mb-3">Permisos Existentes</h4>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <input type="text" class="form-control w-25" placeholder="Buscar">
                </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" aria-label="Select all">
                        </th>
                        <th scope="">Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" aria-label="Select row"></td>
                        <td>Gestión de usuarios</td>
                        <td class="text-end">
                            <a href="#" class="text-warning text-decoration-none"><i class="bi bi-pencil"></i>Edit</a>
                            <a href="#" class="text-danger text-decoration-none"><i class="bi bi-trash-fill"></i>Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" aria-label="Select row"></td>
                        <td>Gestión de permisos</td>
                        <td class="text-end">
                            <a href="#" class="text-warning text-decoration-none"><i class="bi bi-pencil"></i>Edit</a>
                            <a href="#" class="text-danger text-decoration-none"><i class="bi bi-trash-fill"></i>Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>Showing 1 to 10 of 50 results</div>
                <div class="d-flex align-items-center">
                    <label for="itemsPerPage" class="me-2">per page</label>
                    <select id="itemsPerPage" class="form-select form-select-sm w-auto">
                        <option selected>10</option>
                        <option>20</option>
                        <option>50</option>
                    </select>
                    <nav aria-label="Page navigation" class="ms-3">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link text-decoration-none" href="#">1</a></li>
                            <li class="page-item"><a class="page-link text-black" href="#">2</a></li>
                            <li class="page-item"><a class="page-link text-black" href="#">3</a></li>
                            <li class="page-item"><a class="page-link text-black" href="#">4</a></li>
                            <li class="page-item"><a class="page-link text-black" href="#">5</a></li>
                            <li class="page-item"><a class="page-link text-black" href="#"><i class="bi bi-caret-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
</div>
              
 @endsection
