<?php

namespace App\Http\Requests\Estudiante;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // regla para verificar permiso 
        return auth()->user()->hasAnyRole(['Administrador', 'Coordinador']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // reglas de validación 
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_seccion' => 'required|integer|exists:secciones,id',
        ];
    }

    /**
     * Custom attribute names for error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            // Nombres de atributos
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'id_seccion' => 'ID de sección',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            // mensajes de error
            'name.required' => 'El :attribute es obligatorio.',
            'name.string' => 'El :attribute debe ser un texto.',
            'name.max' => 'El :attribute no puede exceder los 255 caracteres.',
            'email.required' => 'El :attribute es obligatorio.',
            'email.string' => 'El :attribute debe ser un texto.',
            'email.email' => 'El :attribute debe ser una dirección de correo electrónico válida.',
            'email.max' => 'El :attribute no puede exceder los 255 caracteres.',
            'email.unique' => 'El :attribute ya está en uso.',
            'password.required' => 'La :attribute es obligatoria.',
            'password.string' => 'La :attribute debe ser un texto.',
            'password.min' => 'La :attribute debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'id_seccion.required' => 'El :attribute es obligatorio.',
            'id_seccion.integer' => 'El :attribute debe ser un número entero.',
            'id_seccion.exists' => 'El :attribute no existe en la base de datos.',
        ];
    }
}
