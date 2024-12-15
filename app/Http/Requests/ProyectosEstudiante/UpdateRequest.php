<?php

namespace App\Http\Requests\ProyectosEstudiante;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'id_proyectos' => 'required|integer',
            'id_estudiantes' => 'required|integer',
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
            'id_proyectos' => 'ID del proyecto',
            'id_estudiantes' => 'ID del estudiante',
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
            'id_proyectos.required' => 'El :attribute es obligatorio.',
            'id_proyectos.integer' => 'El :attribute debe ser un número entero.',
            'id_estudiantes.required' => 'El :attribute es obligatorio.',
            'id_estudiantes.integer' => 'El :attribute debe ser un número entero.',
        ];
    }
}
