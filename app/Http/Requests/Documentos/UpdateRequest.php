<?php

namespace App\Http\Requests\Documentos;

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
            'id_proyecto' => 'required|exists:proyectos,id',
            'tipo_documento' => 'required|string|max:255',
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
            'id_proyecto' => 'ID del proyecto',
            'tipo_documento' => 'Tipo de documento',
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
            'id_proyecto.required' => 'El :attribute es obligatorio.',
            'id_proyecto.exists' => 'El :attribute no existe en la base de datos.',
            'tipo_documento.required' => 'El :attribute es obligatorio.',
            'tipo_documento.string' => 'El :attribute debe ser un texto.',
            'tipo_documento.max' => 'El :attribute no puede exceder los 255 caracteres.',
        ];
    }
}
