<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSelectedRequest extends FormRequest
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
            'users' => 'required|array',
            'users.*' => 'exists:users,id_usuario', // Asegura que cada ID de usuario exista en la tabla 'users'
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
            'users' => 'lista de usuarios',
            'users.*' => 'usuario',
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
            'users.required' => 'La :attribute es obligatoria.',
            'users.array' => 'La :attribute debe ser un array.',
            'users.*.exists' => 'El :attribute seleccionado no es válido.',
        ];
    }
}
