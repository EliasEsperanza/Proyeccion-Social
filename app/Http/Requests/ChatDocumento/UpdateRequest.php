<?php

namespace App\Http\Requests\ChatDocumento;

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
            'id_documentos' => 'required|exists:documentos,id',
            'id_chats' => 'required|exists:chats,id',
            'fecha_envio' => 'required|date',
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
            'id_documentos' => 'ID del documento',
            'id_chats' => 'ID del chat',
            'fecha_envio' => 'Fecha de envío',
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
            'id_documentos.required' => 'El :attribute es obligatorio.',
            'id_documentos.exists' => 'El :attribute no existe en la base de datos.',
            'id_chats.required' => 'El :attribute es obligatorio.',
            'id_chats.exists' => 'El :attribute no existe en la base de datos.',
            'fecha_envio.required' => 'La :attribute es obligatoria.',
            'fecha_envio.date' => 'La :attribute debe ser una fecha válida.',
        ];
    }
}
