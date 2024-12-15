<?php

namespace App\Http\Requests\SeccionTutor;

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
            'id_seccion' => 'required|exists:secciones,id_seccion',
            'id_tutor' => 'required|exists:users,id_usuario',
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
            'id_seccion' => 'sección',
            'id_tutor' => 'tutor',
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
            'id_seccion.required' => 'La :attribute es obligatoria.',
            'id_seccion.exists' => 'La :attribute seleccionada no es válida.',
            'id_tutor.required' => 'El :attribute es obligatorio.',
            'id_tutor.exists' => 'El :attribute seleccionado no es válido.',
        ];
    }
}
