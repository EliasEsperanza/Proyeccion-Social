<?php

namespace App\Http\Requests\HistorialDepartamento;

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
            'id_departamento' => 'required|unique:departamentos,id_departamento|integer',
            'accion' => 'required|string|max:255', // Si se modifica, rechazo o aprobó 
            'nombre_departamento' => 'nullable|string|max:255',
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
            'id_departamento' => 'ID del departamento',
            'accion' => 'acción',
            'nombre_departamento' => 'nombre del departamento',
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
            'id_departamento.required' => 'El :attribute es obligatorio.',
            'id_departamento.unique' => 'El :attribute ya existe. Por favor, elige otro ID.',
            'id_departamento.integer' => 'El :attribute debe ser un número entero.',
            'accion.required' => 'La :attribute es obligatoria.',
            'accion.string' => 'La :attribute debe ser una cadena de texto.',
            'accion.max' => 'La :attribute no puede tener más de :max caracteres.',
            'nombre_departamento.string' => 'El :attribute debe ser una cadena de texto.',
            'nombre_departamento.max' => 'El :attribute no puede tener más de :max caracteres.',
        ];
    }
}
