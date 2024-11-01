@extends('layouts.base')

@section('title', 'Registro')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
@endsection

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 registro-card shadow">
        <h3 class="text-center mb-4 fw-bold">Registrarse</h3>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" placeholder="example@ues.edu.sv.com" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="contrasena" placeholder="Contraseña" required>
                    <button type="button" class="btn btn-outline-secondary" id="botonMostrarContrasena" data-campo="contrasena" data-icono="iconoMostrarContrasena">
                        <i id="iconoMostrarContrasena" class="bi bi-eye-slash"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="confirmarContrasena" class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirmarContrasena" placeholder="Confirmar contraseña" required>
                    <button type="button" class="btn btn-outline-secondary" id="botonMostrarContrasena" data-campo="confirmarContrasena" data-icono="iconoMostrarConfirmarContrasena">
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
<script src="{{ asset('js/login.js') }}"></script>
@endsection