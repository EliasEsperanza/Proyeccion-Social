<?php

namespace App\Http\Requests\HistorialHorasActualizada;

use Illuminate\Foundation\Http\FormRequest;

class AceptarHorasRequest extends FormRequest
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
            'horas_aceptadas' => 'required|numeric|min:0', // Asegúrate de que sea un valor numérico
            'fecha_aceptacion' => 'required|date',
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
            'id_solicitud' => 'ID de la solicitud',
            'horas' => 'Horas registradas',
            'descripcion' => 'Descripción',
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
            'horas.required' => 'Las :attribute son obligatorias.',
            'horas.integer' => 'Las :attribute deben ser un número entero.',
            'horas.min' => 'Las :attribute deben ser al menos 0.',
            'horas.max' => 'Las :attribute no pueden superar las 500 horas.',
            'descripcion.string' => 'La :attribute debe ser un texto.',
            'descripcion.max' => 'La :attribute no puede exceder los 255 caracteres.',
        ];
    }
}
