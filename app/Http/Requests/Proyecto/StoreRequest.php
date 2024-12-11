<?php

namespace App\Http\Requests\Proyecto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'titulo' => ['required', 'string', 'max:255', 'regex:/^\S.*$/', Rule::unique('proyectos', 'nombre_proyecto'),], // Valida que el nombre sea único
            'descripcion' => 'required|string|min:10|max:1000', // Longitud mínima y máxima
            'horas' => 'required|integer|min:1|max:500', // Número válido
            'ubicacion' => 'required|string|max:255|regex:/^\S.*$/', // No permite espacios al inicio
            'id_seccion' => 'required|exists:secciones,id_seccion', // Debe existir en la tabla 'secciones'
        ];
    }

    /**
     * 
     * Attributes names
     */

    public function attributes(): array
    {
        return [
            'titulo' => 'Nombre del proyecto',
            'descripcion' => 'Descripcion del proyecto',
            'horas' => 'Horas requeridas',
            'ubicacion' => 'Ubicacion del proyecto',
            'id_seccion' => 'Seccion',
        ];
    }

    /**
     * 
     * Messages
     */

    public function messages(): array
    {
        return [
            'titulo.required' => 'El nombre del proyecto es obligatorio.',
            'titulo.unique' => 'Ya existe un proyecto con este nombre, prueba con otro.',
            'descripcion.required' => 'La descripción del proyecto es obligatoria.',
            'horas.required' => 'Indique las horas requeridas.',
            'ubicacion.required' => 'La ubicación del proyecto es obligatoria.',
            'id_seccion.required' => 'Seleccione una sección para el proyecto.',
        ];
    }
}
