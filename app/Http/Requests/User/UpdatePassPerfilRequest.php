<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassPerfilRequest extends FormRequest
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
            'contrasena_actual' => 'required',
            'nueva_contrasena' => ['required','string','min:8','confirmed', 'different:contrasena_actual', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/' ],
            'nueva_contrasena_confirmation' => 'required'
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
            'contrasena_actual' => 'contraseña actual',
            'nueva_contrasena' => 'nueva contraseña',
            'nueva_contrasena_confirmation' => 'confirmación de nueva contraseña',
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
            'contrasena_actual.required' => 'La :attribute es requerida.',
            'nueva_contrasena.required' => 'La :attribute es requerida.',
            'nueva_contrasena.min' => 'La :attribute debe tener al menos 8 caracteres.',
            'nueva_contrasena.confirmed' => 'Las contraseñas no coinciden.',
            'nueva_contrasena.different' => 'La nueva contraseña debe ser diferente a la actual.',
            'nueva_contrasena.regex' => 'La :attribute debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
            'nueva_contrasena_confirmation.required' => 'Debe confirmar la nueva contraseña.',
        ];
    }
}
