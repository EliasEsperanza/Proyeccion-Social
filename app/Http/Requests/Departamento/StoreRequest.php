<?php

namespace App\Http\Requests\Departamento;

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
            'nombre_departamento' => 'required|unique:departamentos,nombre_departamento,' . $this->id_departamento . '|string|max:60',
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
            'nombre_departamento' => 'Nombre del departamento',

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
            'nombre_departamento.required' => 'El :attribute es requerido.',
            'nombre_departamento.max' => 'El :attribute no debe exceder los 60 caracteres.',
            'nombre_departamento.unique' => 'El :attribute ya existe, intente con otro.',
        ];
    }
}
