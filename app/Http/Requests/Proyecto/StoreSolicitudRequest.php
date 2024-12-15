<?php

namespace App\Http\Requests\Proyecto;

use Illuminate\Foundation\Http\FormRequest;

class StoreSolicitudRequest extends FormRequest
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
            'nombre_proyecto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'lugar' => 'required|string|max:255',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'id_seccion' => 'required|integer|exists:secciones,id_seccion',
            'estudiantes' => 'required|string',
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
            'nombre_proyecto' => 'Titulo del proyecto',
            'descripcion' => 'Descripcion',
            'lugar' => 'Ubicacion',
            'fecha_inicio' => 'Fecha de inicio',
            'fecha_fin' => 'Fecha finalizacion',
            'id_seccion' => 'Seccion',
            'estudiantes' => 'Integtrantes',
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
            'nombre_proyecto.required' => 'El nombre del proyecto es obligatorio.',
            'nombre_proyecto.string' => 'El nombre del proyecto debe ser una cadena de texto.',
            'nombre_proyecto.max' => 'El nombre del proyecto no debe exceder los 255 caracteres.',

            'descripcion.required' => 'La descripción del proyecto es obligatoria.',
            'descripcion.string' => 'La descripción del proyecto debe ser una cadena de texto.',

            'lugar.required' => 'El lugar del proyecto es obligatorio.',
            'lugar.string' => 'El lugar del proyecto debe ser una cadena de texto.',
            'lugar.max' => 'El lugar del proyecto no debe exceder los 255 caracteres.',

            'fecha_inicio.required' => 'La fecha de inicio del proyecto es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_inicio.before_or_equal' => 'La fecha de inicio debe ser anterior o igual a la fecha de finalización.',

            'fecha_fin.required' => 'La fecha de finalización del proyecto es obligatoria.',
            'fecha_fin.date' => 'La fecha de finalización debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser posterior o igual a la fecha de inicio.',

            'id_seccion.required' => 'La sección del proyecto es obligatoria.',
            'id_seccion.integer' => 'La sección debe ser un número entero.',
            'id_seccion.exists' => 'La sección seleccionada no existe en la base de datos.',

            'estudiantes.required' => 'Debe seleccionar al menos un estudiante para el proyecto.',
            'estudiantes.string' => 'La lista de estudiantes debe ser una cadena de texto válida.',
        ];
    }
}
