
<h1>Test Excel Export departamentos</h1>
<a href="{{route('Departamaento.Exportexcel')}}">Exportar a Excel</a>

<h1>Test pdf Export departamentos</h1>
<a href="{{route('Departamaento.ExportPdf')}}">Exportar a pdf</a>

<hr>
@if ($departamentos)
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Departamento</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($departamentos as $item )

        <tr>
            <td>{{ $item['id_departamento'] }}</td>
            <td>{{ $item['nombre_departamento'] }}</td>
        </tr>

        @endforeach
    </tbody>
</table>
@endif

<hr>

<h1>Crear Departamento</h1>
@if(session('success1'))
{{ session('success1') }} !
@endif
<form action="{{ route('departamentos.store') }}" method="POST">

    @csrf

    <div class="form-group">
        <label for="nombre_departamento">Nombre del Departamento</label>
        <input type="text" name="nombre_departamento" class="form-control" required maxlength="60" placeholder="Ingrese el nombre del departamento">
    </div>
    <button type="submit" class="btn btn-primary">Crear Departamento</button>
</form>

<hr>
<h1>Test de historial export</h1>

@if ($historial_departamentos)
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Departamento</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($historial_departamentos as $item )

        <tr>
            <td>{{ $item['id_departamento'] }}</td>
            <td>{{ $item['accion'] }}</td>
            <td>{{ $item['nombre_departamento'] }}</td>

        </tr>

        @endforeach
    </tbody>
</table>
@endif

<h1>Test Excel Export historial cambios de departamentos</h1>
<a href="{{route('Departamaento.ExportexcelHistotial')}}">Exportar a Excel</a>

<h1>Test pdf Export historial cambios de departamentos</h1>
<a href="{{route('Departamaento.ExportPdfHistotial')}}">Exportar a pdf</a>

<hr>
<h1>Asignar usuario a departamento</h1>
@if ($usuarios)
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>nombre</th>

            <th>Departamento id</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $item )

        <tr>
            <td>{{ $item['id'] }}</td>
            <td>{{ $item['nombre'] }}</td>
            <td>{{ $item['departamento_id'] }}</td>

        </tr>

        @endforeach
    </tbody>
</table>
<br>
@endif
@if(session('success2'))
{{ session('success') }} !
@endif
<form action="{{ route('departamentos.store') }}" method="POST">

    @csrf
    <label for="user">Usuario id:</label>
    <input type="select" id="user" name="fruiuserts" list="id-users">

    <datalist id="id-users">
        @foreach ($usuarios as $item )
        <option value="{{ $item['id']}}">
            @endforeach

    </datalist>

    <label for="departamento">Departamento id:</label>
    <input type="select" id="departamento" name="departamento" list="id-departamentos">

    <datalist id="id-departamentos">
        @foreach ($departamentos as $item )
        <option value="{{ $item['id_departamento']}}">
            @endforeach

    </datalist>
    <br>
    <button type="submit" class="btn btn-primary">Asignar</button>

</form>

<hr>