<?php

namespace App\Http\Requests\HistorialHorasActualizada;

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
            'id_estudiante' => 'required|exists:estudiantes,id_estudiante',
            'id_solicitud' => 'required|exists:solicitudes,solicitud_id',
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
            'id_estudiante' => 'DUE del estudiante',
            'id_solicitud' => 'ID de la solicitud',
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
            'id_estudiante.exists' => 'El :attribute no existe en la base de datos.',
            'id_solicitud.required' => 'El :attribute es obligatorio.',
            'id_solicitud.exists' => 'El :attribute no existe en la base de datos.',
        ];
    }
}
