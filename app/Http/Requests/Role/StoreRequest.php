<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id', // Cada permiso debe existir en la tabla 'permissions'
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
            'name' => 'nombre del rol',
            'permissions' => 'permisos',
            'permissions.*' => 'permiso', // Para cada permiso en el array
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
            'name.unique' => 'El :attribute ya existe. Por favor, elige otro nombre.',
            'permissions.array' => 'Los :attribute deben ser un array.',
            'permissions.*.exists' => 'El :attribute seleccionado no es válido.',
        ];
    }
}
