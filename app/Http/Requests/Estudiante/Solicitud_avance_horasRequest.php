<?php

namespace App\Http\Requests\Estudiante;

use Illuminate\Foundation\Http\FormRequest;

class Solicitud_avance_horasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // regla para verificar permiso 
        return auth()->user()->hasRole('Estudiante');
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
            'horasTrabajadas' => 'required|numeric|min:0',
            'documentos' => 'required|file|mimes:pdf',
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
            'horasTrabajadas' => 'Horas trabajadas',
            'documentos' => 'documentos',
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
            'horasTrabajadas.required' => 'El campo horas trabajadas es obligatorio',
            'horasTrabajadas.numeric' => 'El campo horas trabajadas debe ser un número',
            'horasTrabajadas.min' => 'El campo horas trabajadas debe ser mayor a 0',
            'documentos.required' => 'El campo documento es obligatorio',
            'documentos.file' => 'El campo documento debe ser un archivo',
            'documentos.mimes' => 'El campo documento debe ser un archivo PDF',

        ];
    }
}
