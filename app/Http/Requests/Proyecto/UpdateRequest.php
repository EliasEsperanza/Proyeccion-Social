<?php

namespace App\Http\Requests\Proyecto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            // Reglas de validación
            'titulo' => ['required', 'string', 'max:255', 'regex:/^\S.*$/', Rule::unique('proyectos', 'nombre_proyecto')->ignore($this->route('id'), 'id_proyecto'),], // Ignorar el proyecto actual
            'descripcion' => 'required|string|max:1000',
            'ubicacion' => 'required|string|max:255',
            'horas' => 'required|integer|min:0',
            'id_seccion' => 'required|exists:secciones,id_seccion',
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
            'titulo' => 'Nombre del proyecto',
            'descripcion' => 'Descripcion del proyecto',
            'horas' => 'Horas requeridas',
            'ubicacion' => 'Ubicacion del proyecto',
            'id_seccion' => 'Seccion',
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
            'titulo.required' => 'El nombre del proyecto es obligatorio.',
            'titulo.unique' => 'Ya existe un proyecto con este nombre, prueba con otro por favor.',
            'descripcion.required' => 'La descripción del proyecto es obligatoria.',
            'horas.required' => 'Indique las horas requeridas.',
            'ubicacion.required' => 'La ubicación del proyecto es obligatoria.',
            'id_seccion.required' => 'Seleccione una sección para el proyecto.',
        ];
    }
}
