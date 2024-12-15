<?php

namespace App\Http\Requests\Estudiante;

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
            'id_usuario' => 'required|integer|exists:users,id',
            'id_seccion' => 'required|integer|exists:secciones,id',
            'porcentaje_completado' => 'required|numeric|min:0|max:100',
            'horas_sociales_completadas' => 'required|integer|min:0|max:500',
            'nombre' => 'required|string|max:255',
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
            'id_usuario' => 'ID de usuario',
            'id_seccion' => 'ID de sección',
            'porcentaje_completado' => 'Porcentaje completado',
            'horas_sociales_completadas' => 'Horas sociales completadas',
            'nombre' => 'Nombre del estudiante',
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
            'id_usuario.required' => 'El :attribute es obligatorio.',
            'id_usuario.integer' => 'El :attribute debe ser un número entero.',
            'id_usuario.exists' => 'El :attribute no existe en la base de datos.',
            'id_seccion.required' => 'El :attribute es obligatorio.',
            'id_seccion.integer' => 'El :attribute debe ser un número entero.',
            'id_seccion.exists' => 'El :attribute no existe en la base de datos.',
            'porcentaje_completado.required' => 'El :attribute es obligatorio.',
            'porcentaje_completado.numeric' => 'El :attribute debe ser un número.',
            'porcentaje_completado.min' => 'El :attribute debe ser al menos 0.',
            'porcentaje_completado.max' => 'El :attribute no puede ser mayor que 100.',
            'horas_sociales_completadas.required' => 'El :attribute es obligatorio.',
            'horas_sociales_completadas.integer' => 'El :attribute debe ser un número entero.',
            'horas_sociales_completadas.min' => 'El :attribute debe ser al menos 0.',
            'horas_sociales_completadas.max' => 'El :attribute no puede superar las 500 horas.',
            'nombre.required' => 'El :attribute es obligatorio.',
            'nombre.string' => 'El :attribute debe ser un texto.',
            'nombre.max' => 'El :attribute no puede exceder los 255 caracteres.',
        ];
    }
}
