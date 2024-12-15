<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'correo' => 'required|email|max:255',
            'contrasena' => 'required|string|min:8|max:20|regex:/[a-zA-Z]/|regex:/[0-9]/',
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
            'correo' => 'correo electrónico',
            'contrasena' => 'contraseña',
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
            'correo.required' => 'El :attribute es obligatorio.',
            'correo.email' => 'El formato del :attribute no es válido.',
            'correo.max' => 'El :attribute no puede exceder los 255 caracteres.',
            'contrasena.required' => 'La :attribute es obligatoria.',
            'contrasena.min' => 'La :attribute debe tener al menos 8 caracteres.',
            'contrasena.max' => 'La :attribute no puede exceder los 20 caracteres.',
            'contrasena.regex' => 'La :attribute debe contener al menos una letra y un número.',
        ];
    }
}
