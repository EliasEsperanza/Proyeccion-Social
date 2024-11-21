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
                @php
                    // Obtener el usuario autenticado
                    $user = auth()->user();
                    $userSeccion = null;

                    // Determinar la sección según el rol
                    if ($user->hasRole('Estudiante')) {
                        $userSeccion = DB::table('estudiantes')
                            ->join('secciones', 'estudiantes.id_seccion', '=', 'secciones.id_seccion')
                            ->where('estudiantes.id_usuario', $user->id_usuario)
                            ->select('secciones.id_seccion', 'secciones.nombre_seccion')
                            ->first();
                    } elseif ($user->hasRole('Tutor')) {
                        $userSeccion = DB::table('seccion_tutor')
                            ->join('secciones', 'seccion_tutor.id_seccion', '=', 'secciones.id_seccion')
                            ->where('seccion_tutor.id_tutor', $user->id_usuario)
                            ->select('secciones.id_seccion', 'secciones.nombre_seccion')
                            ->first();
                    } elseif ($user->hasRole('Coordinador')) {
                        $userSeccion = DB::table('secciones')
                            ->where('id_coordinador', $user->id_usuario)
                            ->select('id_seccion', 'nombre_seccion')
                            ->first();
                    }

                    // Filtrar proyectos según la sección del usuario
                    $filteredProjects = $proyectos->filter(function ($proyecto) use ($user, $userSeccion) {
                        // Mostrar todos los proyectos si es administrador
                        if ($user->hasRole('Administrador')) {
                            return true;
                        }

                        // Validar que el proyecto pertenece a la misma sección que el usuario
                        return $proyecto->seccion->id_seccion == ($userSeccion->id_seccion ?? null);
                    });
                @endphp

                @if($filteredProjects->isNotEmpty())
                    @foreach ($filteredProjects as $proyecto)
                        <tr>
                            <td><input type="checkbox" class="form-check-input" value="{{ $proyecto->id_proyecto }}"></td>
                            <td>{{ $proyecto->nombre_proyecto }}</td>
                            <td>{!! strip_tags($proyecto->descripcion_proyecto) !!}</td>
                            <td>{{ $proyecto->horas_requeridas }}</td>
                            <td>{{ $proyecto->lugar }}</td>
                            <td>
                                @if ($proyecto->seccion)
                                    {{ $proyecto->seccion->nombre_seccion }}
                                    @if ($proyecto->seccion->departamento)
                                        / {{ $proyecto->seccion->departamento->nombre_departamento }}
                                    @endif
                                @else
                                    No asignada
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('detalle', ['id' => $proyecto->id_proyecto]) }}" class="btn btn-light btn-sm p-2 px-3">
                                        <i class="bi bi-eye text-muted"></i>
                                    </a>
                                    <a href="{{ route('proyecto.editar-proyecto', ['id' => $proyecto->id_proyecto]) }}" class="btn btn-light btn-sm p-2 px-3">
                                        <i class="bi bi-pencil text-warning"></i>
                                    </a>
                                    <form action="{{ route('proyecto.eliminarProyecto', ['id' => $proyecto->id_proyecto]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm p-2 px-3">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">No hay proyectos disponibles</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
