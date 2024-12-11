<?php

namespace App\Http\Requests\Proyecto;

use Illuminate\Foundation\Http\FormRequest;

class AsignarProyectoRequest extends FormRequest
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
            'idTutor' => 'required|string|exists:users,id_usuario',
            'lugar' => 'nullable|string|max:255',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|required_with:fecha_inicio|after_or_equal:fecha_inicio',
            'estado' => 'required|integer|exists:estados,id_estado',
            'seccion_id' => 'required|exists:secciones,id_seccion',
            'horas' => 'required|integer|min:0',

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
            'idTutor' => 'Tutor',
            'lugar' => 'Ubicacion',
            'fecha_inicio' => 'Fecha de inicio',
            'fecha_fin' => 'Fecha de finalizacion',
            'estado' => 'Estado',
            'seccion_id' => 'Seccion o Departamento',
            'horas' => 'Horas requeridas.',
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
            'idTutor.required' => 'Seleccione un tutor por favor.',
            'idTutor.exists' => 'El tutor seleccionado no es válido.',
            'estado.required' => 'El estado del proyecto es obligatorio.',
            'estado.exists' => 'El estado seleccionado no es válido.',
            'seccion_id.required' => 'La sección es obligatoria.',
            'seccion_id.exists' => 'La sección seleccionada no es válida.',
            'horas.required' => 'Debe especificar las horas requeridas.',
            'horas.min' => 'Las horas requeridas deben ser un número positivo.',
        ];
    }
}
