<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="card p-4 shadow login-card">
        <h3 class="text-center mb-4 fw-bold">Cambiar Contraseña</h3>
        
        <form action="{{route('updatepassword',['idUser'=>$idUser])}}" method="POST">
            @csrf
            <div class="mb-3">
  <label for="codigo_verificacion" class="form-label">Código de verificación</label>
  <div class="input-group">
    <span style="  transform: scaleX(1.2);
    font-size: 1.1rem; "  class="input-group-text float-start"><i class="bi bi-envelope"></i></span>
    <input type="text" class="form-control" id="codigo_verificacion" name="codigo_verificacion" required>
    @if (session()->has('error'))
    <div class="invalid-feedback d-block">
        {{ session('error') }}
    </div>
    @endif
  </div>
</div>

  <div class="mb-3">
    <label for="nueva_contrasena" class="form-label">Nueva Contraseña</label>
    <div class="input-group">
        <span style="  transform: scaleX(1.2);
    font-size: 1.1rem; "  class="input-group-text">
            <i class="bi bi-lock"></i>
        </span>
        <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" placeholder="Ingrese la nueva contraseña" required>
        <span class="input-group-text">
            <i class="bi bi-eye-slash" id="togglePassword1"></i>
        </span>
    </div>
</div>

<div class="mb-3">
    <label for="confirmar_contrasena" class="form-label">Confirmar Nueva Contraseña</label>
    <div class="input-group">
        <span style="  transform: scaleX(1.2);
    font-size: 1.1rem; "  class="input-group-text">
            <i class="bi bi-lock"></i>
        </span>
        <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirme la nueva contraseña" required>
        <span class="input-group-text">
            <i class="bi bi-eye-slash" id="togglePassword2"></i>
        </span>
    </div>
</div>

<button type="submit" class="btn btn-primary w-100 mb-3 fw-bold">Cambiar contraseña</button>
                
       
        </form>
    </div>

    <script src="{{ asset('js/auth.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
