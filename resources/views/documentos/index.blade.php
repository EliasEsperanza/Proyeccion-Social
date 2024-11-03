<!-- documentos/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Documentos</h1>
    
    <!-- Formulario para filtros de búsqueda -->
    <form action="{{ route('documentos.index') }}" method="GET">
        <div>
            <label for="id_proyecto">ID Proyecto:</label>
            <input type="text" name="id_proyecto" id="id_proyecto" value="{{ request('id_proyecto') }}">
        </div>
        <div>
            <label for="tipo_documento">Tipo de Documento:</label>
            <input type="text" name="tipo_documento" id="tipo_documento" value="{{ request('tipo_documento') }}">
        </div>
        <button type="submit">Buscar</button>
    </form>

    <!-- Listado de documentos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Proyecto</th>
                <th>Tipo Documento</th>
                <th>Ruta Archivo</th>
                <th>Fecha Subida</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documentos as $documento)
                <tr>
                    <td>{{ $documento->id }}</td>
                    <td>{{ $documento->id_proyecto }}</td>
                    <td>{{ $documento->tipo_documento }}</td>
                    <td>{{ $documento->ruta_archivo }}</td>
                    <td>{{ $documento->fecha_subida }}</td>
                    <td>
                        <a href="{{ route('documentos.edit', $documento->id) }}">Editar</a>
                        <form action="{{ route('documentos.destroy', $documento->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Enlace de paginación -->
    {{ $documentos->links() }}
@endsection
