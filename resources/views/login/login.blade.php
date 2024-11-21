<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal de inicio de sesión del sistema">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - {{ config('app.name', 'Sistema') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow login-card border-0">
            <div class="card-body">
                <h3 class="text-center mb-4 fw-bold">Iniciar sesión</h3>

                <form action="{{ route('login.process') }}" method="POST" class="needs-validation" novalidate autocomplete="off">
                    @csrf

                    @if($errors->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ $errors->first('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email"
                                class="form-control @error('correo') is-invalid @enderror"
                                id="correo"
                                name="correo"
                                placeholder="example@ues.edu.sv"
                                value="{{ old('correo') }}"
                                required
                                pattern="[a-z0-9._%+-]+@ues\.edu\.sv$">
                            @error('correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">
                                Por favor ingrese un correo institucional válido (@ues.edu.sv)
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password"
                                class="form-control @error('contrasena') is-invalid @enderror"
                                id="contrasena"
                                name="contrasena"
                                required
                                minlength="8">
                            <button type="button"
                                class="btn btn-outline-secondary"
                                id="botonMostrarContrasena"
                                title="Mostrar/Ocultar contraseña">
                                <i class="bi bi-eye-slash" id="iconoMostrarContrasena"></i>
                            </button>
                            @error('contrasena')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">
                                La contraseña es requerida
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 text-end">
                        <a href="{{ route('recuperarpassword') }}"
                            class="text-decoration-none text-muted">
                            ¿Has olvidado tu contraseña?
                        </a>
                    </div>

                    <button type="submit"
                        class="btn btn-primary w-100 mb-3 fw-bold d-flex align-items-center justify-content-center gap-2">
                        <span>Iniciar sesión</span>
                        <i class="bi bi-box-arrow-in-right"></i>
                    </button>

                    <div class="text-center">
                        <small>
                            ¿Aún no tienes una cuenta?
                            <a href="{{ route('registro') }}" class="text-danger text-decoration-none fw-bold">
                                Regístrate Aquí
                            </a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>

</body>

</html>