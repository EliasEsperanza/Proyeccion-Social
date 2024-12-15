<?php

namespace App\Http\Requests\Historial;

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
            'proyecto_id' => 'required|integer',
            'estado_anterior' => 'required|string',
            'estado_nuevo' => 'required|string',
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
            'proyecto_id' => 'ID del proyecto',
            'estado_anterior' => 'Estado anterior',
            'estado_nuevo' => 'Estado nuevo',
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
            'proyecto_id.required' => 'El :attribute es obligatorio.',
            'proyecto_id.integer' => 'El :attribute debe ser un número entero.',
            'proyecto_id.exists' => 'El :attribute no existe en la base de datos.',
            'estado_anterior.required' => 'El :attribute es obligatorio.',
            'estado_anterior.string' => 'El :attribute debe ser un texto.',
            'estado_anterior.max' => 'El :attribute no puede exceder los 255 caracteres.',
            'estado_nuevo.required' => 'El :attribute es obligatorio.',
            'estado_nuevo.string' => 'El :attribute debe ser un texto.',
            'estado_nuevo.max' => 'El :attribute no puede exceder los 255 caracteres.',
        ];
    }
}
