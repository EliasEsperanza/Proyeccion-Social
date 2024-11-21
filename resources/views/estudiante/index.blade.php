@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container-fluid mt-1">
    <h2 class="text-start mb-4">Lista de Estudiantes</h2>
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
                    <th scope="col">id</th>
                    <th scope="col">Correo Electrónico</th>
                    <th scope="col">Sección/Departamento</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($ListEstudiantes as $estudiante)    
                <tr>
                    <td><input type="checkbox"></td>
                    <td>{{$estudiante->usuario->name}}</td>
                    <td>{{$estudiante->id_estudiante}}</td>
                    <td>{{$estudiante->usuario->email}}</td>
                    <td>{{$estudiante->seccion->nombre_seccion}}</td>
                    <td>
                        <a href="#" class="text-warning me-3"><i class="bi bi-pencil"></i> Editar</a>
                        <a href="#" class="text-danger"><i class="bi bi-trash"></i> Eliminar</a>
                        <a href="{{ route(name:'perfil')}}" class="text-danger"><i class="bi bi-eye"></i> Mostrar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('estudiantes.create') }}">crear estudiante</a>

@endsection