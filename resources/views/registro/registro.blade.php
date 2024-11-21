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

            <form action="{{ route('usuarios.registro') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text"
                            name="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            id="nombre"
                            placeholder="Nombre completo"
                            value="{{ old('nombre') }}"
                            required>
                        @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Actualiza la sección del correo -->
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email"
                            name="correo"
                            class="form-control @error('correo') is-invalid @enderror"
                            id="correo"
                            placeholder="example@ues.edu.sv"
                            value="{{ old('correo') }}"
                            required>
                        @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            placeholder="Contraseña"
                            required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-campo="contrasena">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">
                        La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="confirmarContrasena" class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password"
                            class="form-control"
                            id="confirmarContrasena"
                            placeholder="Confirmar contraseña"
                            required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-campo="confirmarContrasena">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 row">
                    <div class="col-md-8">
                        <label for="id_seccion" class="form-label">Sección/Departamento</label>
                        <select name="id_seccion"
                            class="form-select @error('id_seccion') is-invalid @enderror"
                            id="id_seccion"
                            required>
                            <option selected disabled value="">Seleccionar departamento</option>
                            @foreach($secciones as $seccion)
                            <option value="{{$seccion->id_seccion}}" {{ old('id_seccion') == $seccion->id_seccion ? 'selected' : '' }}>
                                {{$seccion->nombre_seccion}}
                            </option>
                            @endforeach
                        </select>
                        @error('id_seccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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