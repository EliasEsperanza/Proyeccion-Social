<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/appE.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mensaje.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'css/notificacion.css')}}">
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-2">
        <div class="container-fluid d-flex align-items-center">
            <!-- Botón para colapsar menú -->
            <button class="btn btn-outline-dark me-2" id="boton-toggle-superior">
                <i class="bi bi-list"></i>
            </button>

            <a href="" class="logo-bienvenida">Plataforma Horas Sociales</a>

            <!-- Barra de búsqueda -->
            <form class="d-flex ms-auto position-relative me-3">
                <input class="form-control rounded-pill ps-5" type="search" placeholder="Buscar" aria-label="Buscar">
                <i class="bi bi-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
            </form>

            <!-- Notificaciones -->
            <div class="position-relative me-3 topbar-notification" id="notification-bell">
                <i class="bi bi-bell" style="font-size: 1.5rem; color: #800000;"></i>
                <span class="badge">4</span>
                <!-- Dropdown de notificaciones -->
                <div class="notification-dropdown">
                    <div class="notification-header">
                        <h6 class="m-0">Notificaciones</h6>
                        <button class="mark-all-read">Marcar todo como leído</button>
                    </div>
                    <div class="notification-list">
                        @isset($notificaciones)
                        @foreach($notificaciones as $noti)
                        <div>
                            <p>{{$noti->mensaje}}</p>
                        </div>
                        @endforeach
                        @endisset
                    </div>
                </div>
            </div>

            <!-- Ícono del perfil -->
            <a href="{{ route('perfil_usuario') }}" class="text-decoration-none">
                <span class="rounded-circle text-white p-2 ms-2" style="background-color: #800000;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'DU', 0, 2)) }}
                </span>
            </a>
        </div>
    </nav>

    @if(auth()->user()->hasRole('Estudiante'))
    <div id="contenedor-principal" class="d-flex">
        <nav id="barra-lateral" class="p-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('estudiantes.dashboard') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-house-door me-2"></i> Inicio
                    </a>
                </li>

                <li class="nav-item text-muted mt-3">Proyectos</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('proyectomio') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-folder me-2"></i> Mi Proyecto
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('solicitud-proyecto') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-pencil-square me-2"></i> Solicitud de Proyecto
                    </a>
                </li>

                <li class="nav-item text-muted mt-3">Guías</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('vista_procesos_horas') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-journal me-2"></i> Proceso de Inscripción
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('documentos_horas_sociales') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-folder2-open me-2"></i> Documentos </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('docs_tramites') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-file-earmark-text me-2"></i> Trámites Generales
                    </a>
                </li>

                <li class="nav-item text-muted mt-3">Mensajería</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mensajeria') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-chat me-2"></i> Mensajes
                    </a>
                </li>

                <li class="nav-item text-muted mt-3">Salir</li>
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">
                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <div id="contenido-principal" class="flex-grow-1">
            <main class="container-fluid">
                @yield('content')
            </main>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/appE.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/graficos.js') }}"></script>
    <script src="{{ asset('js/mensaje.js') }}"></script>
    <script src="{{ asset('js/showPassword.js') }}"></script>
    <script src="{{ asset('js/busqueda.js') }}"></script>
    <script src="{{ asset('js/notificacion.js') }}"></script>

    <!--Yield para scripts en otros blades -->
    @yield('scripts')

</body>

</html>