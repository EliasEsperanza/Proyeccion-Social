@extends('layouts.app')

@section('title', 'Proyectos Disponibles')

@section('content')

<h2 class="my-4">Proyectos disponibles</h2>

<div class="buscar grupo-entrada mb-3 d-flex align-items-center rounded shadow-sm p-2 bg-white mx-auto" style="max-width: 700px;">
    <input type="text" class="form-control border-0 shadow-none" placeholder="Buscar proyectos..." aria-label="Buscar proyectos">
    <button class="btn btn-light p-2 ms-2 px-3" type="button">
        <i class="bi bi-filter text-muted"></i>
    </button>
</div>

<div class="tabla-contenedor shadow-sm rounded bg-white">
    <div class="table-responsive">
        <table class="table tabla-hover align-middle mb-0">
            <thead class="tabla-clara border-bottom">
                <tr>
                    <th scope="col"><input type="checkbox" class="form-check-input"></th>
                    <th scope="col">Título del proyecto</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Horas requeridas</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Sección/Departamento</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" class="form-check-input"></td>
                    <td>Gestor de TI</td>
                    <td>Mantenimiento de TI</td>
                    <td>500</td>
                    <td>UES-FMO</td>
                    <td>Sistemas Informáticos</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('detalle') }}" class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-eye text-muted"></i>
                            </a>
                            <a class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-pencil text-warning"></i>
                            </a>
                            <a class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-trash text-danger"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><input type="checkbox" class="form-check-input"></td>
                    <td>Desarrollador Web</td>
                    <td>Desarrollo de una plataforma web para gestión de contenidos</td>
                    <td>300</td>
                    <td>UES-SM</td>
                    <td>Ingeniería de Sistemas</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('detalle') }}" class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-eye text-muted"></i>
                            </a>
                            <a class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-pencil text-warning"></i>
                            </a>
                            <a class="btn btn-light btn-sm p-2 px-3">
                                <i class="bi bi-trash text-danger"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="p-3 d-flex flex-column flex-md-row justify-content-between align-items-center bg-light border-top">
        <span class="text-muted mb-2 mb-md-0">Mostrando 1 a 10 de 50 resultados</span>
        <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
            <select class="form-select form-select-sm" style="width: auto;">
                <option>10</option>
                <option>20</option>
                <option>50</option>
            </select>
            <span>por página</span>
        </div>
        <ul class="paginacion d-flex gap-2 mb-0">
            <li class="pagina-item activo">
                <a class="pagina-enlace" href="#">1</a>
            </li>
            <li class="pagina-item"><a class="pagina-enlace" href="#">2</a></li>
            <li class="pagina-item"><a class="pagina-enlace" href="#">3</a></li>
            <li class="pagina-item"><a class="pagina-enlace" href="#">4</a></li>
            <li class="pagina-item"><a class="pagina-enlace" href="#">5</a></li>
            <li class="pagina-item"><a class="pagina-enlace" href="#"><i class="bi bi-chevron-right"></i></a></li>
        </ul>
    </div>
</div>

@endsection
