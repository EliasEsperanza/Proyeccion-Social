<?php

namespace App\Http\Requests\Documentos;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoRequest extends FormRequest
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
            'file' => 'required|file|mimes:pdf,doc,docx,txt|max:2048', // Máximo 2 MB
            'id_proyecto' => 'required|integer',
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
            'file' => 'archivo',
            'id_proyecto' => 'proyecto',
            'tipo_documento' => 'tipo de documento',
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
            'file.required' => 'El :attribute es obligatorio.',
            'file.file' => 'El :attribute debe ser un archivo válido.',
            'file.mimes' => 'El :attribute debe ser un archivo de tipo: pdf, doc, docx o txt.',
            'file.max' => 'El :attribute no debe exceder los 2 MB.',

            'id_proyecto.required' => 'El :attribute es obligatorio.',
            'id_proyecto.integer' => 'El :attribute debe ser un número entero.',

            'tipo_documento.required' => 'El :attribute es obligatorio.',
            'tipo_documento.string' => 'El :attribute debe ser una cadena de texto.',
            'tipo_documento.max' => 'El :attribute no debe exceder los 255 caracteres.',
        ];
    }
}
