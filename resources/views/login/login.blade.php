<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow login-card">
        <h3 class="text-center mb-4 fw-bold">Iniciar sesión</h3>
        
        <form action="" method="POST">
            @csrf
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="correo" name="correo" placeholder="example@ues.edu.sv" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock icono-candado"></i></span>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                    <button type="button" class="btn btn-outline-secondary" id="botonMostrarContrasena">
                        <i class="bi bi-eye-slash" id="iconoMostrarContrasena"></i>
                    </button>
                </div>

            </div>

            <div class="mb-3 text-end">
                <a href="" class="text-muted">¿Has olvidado tu contraseña?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3 fw-bold">Iniciar sesión</button>
            
            <div class="text-center">
              <small>Aún no tienes una cuenta? <a href="" class="text-danger link-registrate">Regístrate Aquí</a></small>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
