<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-2">
        <div class="container-fluid">
            <button class="btn btn-outline-dark" id="boton-toggle-superior">
                <i class="bi bi-list"></i>
            </button>

            <form class="d-flex ms-auto position-relative">
                <input class="form-control rounded-pill ps-5" type="search" placeholder="Buscar" aria-label="Buscar">
                <i class="bi bi-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
            </form>


            <div class="d-flex align-items-center">
                <span class="rounded-circle text-white p-2 ms-2 badge">DU</span>
            </div>
        </div>
    </nav>

    <div id="contenedor-principal" class="d-flex">
        <nav id="barra-lateral" class="p-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#" onclick="establecerActivo(this)">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item text-muted">Usuarios</li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="establecerActivo(this)">
                        <i class="bi bi-gear me-2"></i> Gestión de Proyectos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('usuarios') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-people me-2"></i> Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('crear') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-people me-2"></i> Gestión de Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route(name:'permisos') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-shield-lock me-2"></i> Gestión de Permisos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-person me-2"></i> Gestión de Roles
                    </a>
                </li>
                <li class="nav-item text-muted mt-3">Proyectos</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('proyecto') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-folder me-2"></i> Publicar Proyectos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="establecerActivo(this)">
                        <i class="bi bi-folder2 me-2"></i> Proyectos Disponibles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('gestion-proyecto') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-file-earmark me-2"></i> Gestión de Proyectos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('proyecto-general') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-briefcase me-2"></i> Proyectos
                    </a>
                </li>
            </ul>
        </nav>

        <div id="contenido-principal" class="flex-grow-1">
            <main class="container-fluid">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>