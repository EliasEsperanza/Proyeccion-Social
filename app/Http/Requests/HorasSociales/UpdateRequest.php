<?php

namespace App\Http\Requests\HorasSociales;

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
            'id_estudiante' => 'required|integer',
            'horas_completadas' => 'required|integer|min:0',
            'fecha_registro' => 'required|date',
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
            'id_estudiante' => 'ID del estudiante',
            'horas_completadas' => 'horas completadas',
            'fecha_registro' => 'fecha de registro',
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
            'id_estudiante.required' => 'El :attribute es obligatorio.',
            'id_estudiante.integer' => 'El :attribute debe ser un número entero.',
            'horas_completadas.required' => 'Las :attribute son obligatorias.',
            'horas_completadas.integer' => 'Las :attribute deben ser un número entero.',
            'horas_completadas.min' => 'Las :attribute deben ser al menos :min.',
            'fecha_registro.required' => 'La :attribute es obligatoria.',
            'fecha_registro.date' => 'La :attribute debe ser una fecha válida.',
        ];
    }
}
