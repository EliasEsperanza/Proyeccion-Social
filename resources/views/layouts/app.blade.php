<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardStyle.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'css/mensaje.css')}}">
    <link rel="stylesheet" href="{{ asset(path: 'css/soliproyecto.css')}}">
    <link rel="stylesheet" href="{{ asset(path: 'css/notificacion.css')}}">
    @yield('styles')

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-2">
        <div class="container-fluid d-flex align-items-center">
            <!-- Botón de Menú -->
            <button class="btn btn-outline-dark me-2" id="boton-toggle-superior">
                <i class="bi bi-list"></i>
            </button>

            <a href="" class="logo-bienvenida">Plataforma Horas Sociales</a>

            <div class="d-flex ms-auto position-relative me-3 topbar-notification" id="notification-bell">
                <i class="bi bi-bell" style="font-size: 1.5rem; color: #800000;"></i>
                <span class="badge notification-count">0</span>

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

            <a href="{{ route('perfil_usuario') }}" class="text-decoration-none">
                <span class="rounded-circle text-white d-flex align-items-center justify-content-center"
                    style="background-color: #800000; width: 40px; height: 40px; border-radius: 50%; transition: all 0.3s ease;">
                    {{ substr(Auth::user()->name ?? 'DU', 0, 2) }}
                </span>
            </a>

        </div>
    </nav>

    <div id="contenedor-principal" class="d-flex">
        <nav id="barra-lateral" class="p-3">

            <ul class="nav flex-column">

                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('dashboard') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-house-door me-2"></i> Dashboard
                    </a>
                </li>

                @if(auth()->user()->hasRole('Administrador'))
                <li class="nav-item text-muted">Usuarios</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('crear') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-person me-2"></i> Registrar Usuario
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="{{ route('usuarios') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-people me-2 "></i> Usuarios
                    </a>
                </li>

                @elseif(auth()->user()->hasRole('Coordinador'))

                <li class="nav-item text-muted">Usuarios</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('crear') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-people me-2"></i> Usuarios
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('usuarios') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-person me-2"></i> Usuarios
                    </a>
                </li>

                @elseif(auth()->user()->hasRole('Tutor'))

                <li class="nav-item text-muted">Usuarios</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('usuarios') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-person me-2"></i> Usuarios
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador']))
                <li class="nav-item text-muted mt-3">Proyectos</li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('proyecto') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-folder-plus me-2"></i> Publicar Proyecto </a>
                </li>

                @if(auth()->user()->hasAnyRole(['Coordinador', 'Administrador']))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('proyecto-disponible') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-folder-check me-2"></i> Proyectos Disponibles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('gestion-proyecto') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-person-plus me-2"></i> Asignar Proyecto
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasAnyRole(['Tutor']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('proyecto-disponible') }}" onclick="establecerActivo(this)">
                            <i class="bi bi-person me-2"></i> Proyectos Disponibles
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('proyecto-g') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-list-check me-2"></i> Proyectos en Curso </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('solicitudes_coordinador') }}" onclick="establecerActivo(this)">
                    <i class="bi bi-file-earmark-text me-2"></i> Solicitud de Proyectos                    </a>
                </li>

                @endif

                @if(auth()->user()->hasAnyRole(['Tutor', 'Coordinador', 'Administrador']))
                <li class="nav-item text-muted mt-3">Mensajería</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mensajeria') }}" onclick="establecerActivo(this)">
                        <i class="bi bi-chat me-2"></i> Mensajes
                    </a>
                </li>
                @endif

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/graficos.js') }}"></script>
    <script src="{{asset(path:'js/mensaje.js') }}"></script>
    <script src="{{ asset('js/showPassword.js') }}"></script>
    <script src="{{ asset('js/busqueda.js') }}"></script>
    <script src="{{ asset('js/notificacion.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Yield para scripts en otros blades -->
    @yield('scripts')
</body>

</html>