<?php

namespace App\Http\Requests\Asignacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsignacionRequest extends FormRequest
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
            'id_proyecto' => 'required|integer|min:1',
            'id_estudiante' => 'required|integer|min:1',
            'id_tutor' => 'required|integer|min:1',
            'fecha_asignacion' => 'required|date|after_or_equal:today',
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
            'id_proyecto' => 'proyecto',
            'id_estudiante' => 'estudiante',
            'id_tutor' => 'tutor',
            'fecha_asignacion' => 'fecha de asignación',
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
            'id_proyecto.required' => 'El proyecto es obligatorio.',
            'id_estudiante.required' => 'El estudiante es obligatorio.',
            'id_tutor.required' => 'El tutor es obligatorio.',
            'fecha_asignacion.required' => 'La fecha de asignación es obligatoria.',
            'fecha_asignacion.after_or_equal' => 'La fecha debe ser hoy o posterior.',
        ];
    }
}
