<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperar Contraseña</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="card card-body shadow login-card">
    @if (session()->has('success'))
            <div class="success-feedback d-block">
                {{ session('success') }}
            </div>
            @endif
      <h5 class="text-start mb-4 fw-bold">Recupera tu cuenta</h5> 
      <hr class="custom-hr">
      <p>Ingresa el correo electrónico asociado a tu cuenta para restablecerla.</p>

      <form action="enviocorreocode" method="POST">
        @csrf

        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico</label>
          <div class="input-group">
            <span  style=" transform: scaleX(1.2);
    font-size: 1.1rem; " class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="example@ues.edu.sv" required>
            @if (session()->has('error'))
            <div class="invalid-feedback d-block">
                {{ session('error') }}
            </div>
            @endif
          </div>
        </div>

        <div class="d-flex justify-content-end"> <a href="/" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-primary ms-2">Enviar</button>
        </div>

      </form>

    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>