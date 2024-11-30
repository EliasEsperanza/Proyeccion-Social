@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container-fluid mt-1">
    <h2 class="text-start mb-4">Crear Nuevo Usuario</h2>

    <div class="card p-4 shadow-sm">
        <form id="crearUsuarioForm" action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Nombre" required>
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror" id="correo" placeholder="example@ues.edu.sv" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña" required>
                        <button class="btn btn-outline-secondary" type="button" id="showPassword">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" class="form-select @error('rol') is-invalid @enderror" id="rol" required>
                        <option selected>Seleccionar Rol</option>
                        @if(auth()->check() && auth()->user()->hasRole('Coordinador'))
                        <option value="tutor">tutor</option>
                        <option value="estudiante">estudiante</option>
                        @else
                        <option value="tutor">tutor</option>
                        <option value="estudiante">estudiante</option>
                        <option value="administrador">administrador</option>
                        <option value="coordinador">coordinador</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="mb-4 row">
                <div class="col-md-6">
                    <label for="id_seccion" class="form-label">Sección/Departamento</label>
                    <select name="id_seccion" class="form-select @error('departamento') is-invalid @enderror" id="id_seccion" required>
                        <option selected>Seleccionar departamento</option>
                        @foreach($secciones as $seccion)
                        @if (Auth::user()->hasRole('Coordinador'))
                        @php
                        $seccionId = Auth::user()->getDepartamentoCoordinador();
                        @endphp

                        @if ($seccion->id_seccion == $seccionId)
                        <option value="{{ $seccion->id_seccion }}">{{ $seccion->nombre_seccion }}</option>
                        @break
                        @endif
                        @else
                        <option value="{{ $seccion->id_seccion }}">{{ $seccion->nombre_seccion }}</option>
                        @endif
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="d-grid">
                <button id="submitButton" type="submit" class="btn btn-primary w-100 mb-3 fw-bold">
                    Crear Usuario
                </button>
            </div>
        </form>
        <!-- Mensaje de éxito -->
        <div id="successMessage" class="alert alert-success d-none mt-3" role="alert">
            Usuario creado exitosamente.
        </div>
    </div>
</div>

<!-- Script para manejar el comportamiento -->
<script>
    document.getElementById('crearUsuarioForm').addEventListener('submit', async function (e) {
        e.preventDefault(); // Evita el envío normal del formulario

        const form = e.target;
        const rol = document.getElementById('rol').value;
        const submitButton = document.getElementById('submitButton');

        // Deshabilitar botón y mostrar indicador de carga
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Procesando...
        `;

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                // Mostrar mensaje de éxito
                const successMessage = document.getElementById('successMessage');
                successMessage.classList.remove('d-none');
                setTimeout(() => {
                    successMessage.classList.add('d-none');

                    // Mostrar confirmación para crear otro usuario
                    if (rol === 'estudiante') {
                        const confirmCreateAnother = confirm('¿Desea crear otro estudiante?');
                        if (confirmCreateAnother) {
                            form.reset(); // Limpia el formulario
                        } else {
                            window.location.href = '{{ route("dashboard") }}'; // Redirige al dashboard
                        }
                    } else {
                        window.location.href = '{{ route("dashboard") }}'; // Redirige al dashboard para otros roles
                    }
                }, 2000); // Espera 2 segundos antes de mostrar la confirmación
            } else {
                const errorText = await response.text();
                console.error('Error en la respuesta:', errorText);
                alert('Hubo un problema al crear el usuario. Inténtalo nuevamente.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Ocurrió un error. Por favor, inténtalo más tarde.');
        } finally {
            // Rehabilitar botón y restaurar texto
            submitButton.disabled = false;
            submitButton.innerHTML = 'Crear Usuario';
        }
    });
</script>
@endsection
