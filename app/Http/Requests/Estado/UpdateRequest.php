<?php

namespace App\Http\Requests\Estado;

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
        $estadoAnterior = $this->route('estado')->nombre_estado; // Obtener el estado anterior desde la ruta

        return [
            'nuevo_estado' => 'required|string|in:' . implode(',', $this->transiciones[$estadoAnterior] ?? []),
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
            'nuevo_estado' => 'Nuevo estado',
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
            'nuevo_estado.required' => 'El :attribute es obligatorio.',
            'nuevo_estado.in' => 'El :attribute no es válido para la transición actual.',
        ];
    }
}
