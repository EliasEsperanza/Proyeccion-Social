<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
    <title>Registro</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card p-4 registro-card shadow">
            <h3 class="text-center mb-4 fw-bold">Registrarse</h3>
    
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope "></i></span>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="example@ues.edu.sv" required>
                    </div>
                </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock icono-candado"></i></span>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                    <button type="button" class="btn btn-outline-secondary" id="botonMostrarContrasena" data-campo="contrasena" data-icono="iconoMostrarContrasena">
                        <i class="bi bi-eye-slash" id="iconoMostrarContrasena"></i>
                    </button>
                </div>

            </div>
    
                <div class="mb-3">
                    <label for="confirmarContrasena" class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock icono-candado"></i></span>
                        <input type="password" class="form-control" id="confirmarContrasena" placeholder="Confirmar contraseña" required>
                        <button type="button" class="btn btn-outline-secondary" id="botonMostrarContrasena2" data-campo="confirmarContrasena" data-icono="iconoMostrarConfirmarContrasena">
                            <i id="iconoMostrarConfirmarContrasena" class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>
    
                <div class="mb-3">
                    <label for="departmento" class="form-label">Sección/Departamento</label>
                    <select class="form-select" id="departmento" required>
                        <option selected disabled>Seleccionar departamento</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark w-100 btn-registrarse">Registrarse</button>
                <div class="text-center mt-3 ">
                    <p>¿Ya tienes una cuenta? <a href="{{ asset('') }}" class="link-inicar-sesion fw-bold">Inicia Sesión Aquí</a></p>
                </div>
    
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/registro.js') }}"></script>
</body>
</html>