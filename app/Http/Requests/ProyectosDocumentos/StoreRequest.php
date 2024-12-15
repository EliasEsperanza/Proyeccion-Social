<?php

namespace App\Http\Requests\ProyectosDocumentos;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'id_documento' => 'required|integer|exists:documentos,id',
            'id_proyecto' => 'required|integer|exists:proyectos,id_proyecto',
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
            'id_documento' => 'ID del documento',
            'id_proyecto' => 'ID del proyecto',
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
            'id_documento.required' => 'El :attribute es obligatorio.',
            'id_documento.integer' => 'El :attribute debe ser un número entero.',
            'id_documento.exists' => 'El :attribute seleccionado no existe en la base de datos.',
            'id_proyecto.required' => 'El :attribute es obligatorio.',
            'id_proyecto.integer' => 'El :attribute debe ser un número entero.',
            'id_proyecto.exists' => 'El :attribute seleccionado no existe en la base de datos.',
        ];
    }
}
