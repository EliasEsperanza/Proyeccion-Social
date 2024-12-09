@extends('layouts.app')

@section('title', 'Crear Estudiante')

@section('content')

    <form>
        <div class="mb-3">
            <label for="exampleInputInput" class="form-label">Nombre</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Correo Electronico</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="exampleInputInput" class="form-label">Rol</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <label for="exampleInputInput" class="form-label">Seccion/Departamento</label>
        <select class="form-select" aria-label="Default select example">
            <option value="1" selected>Seleccionar Departamento</option>
            @foreach($secciones as $seccion)
                <option value="{{ $seccion->id_seccion }}">{{ $seccion->nombre_seccion }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
@endsection
