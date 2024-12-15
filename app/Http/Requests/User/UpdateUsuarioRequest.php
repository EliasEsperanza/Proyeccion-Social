<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
        $id = $this->route('id'); // Obtiene el ID del usuario desde la ruta

        // reglas de validación 
        return [
            'nombre' => [
                'required',
                'string',
                'max:28',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            ],
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $id, // Ajustar según la clave primaria
                'ends_with:@ues.edu.sv',
            ],
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
            'nombre' => 'nombre completo',
            'correo' => 'correo electrónico',
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
            'nombre.required' => 'El :attribute es obligatorio.',
            'nombre.max' => 'El :attribute no puede tener más de 28 caracteres.',
            'nombre.regex' => 'El :attribute solo puede contener letras y espacios.',
            'correo.required' => 'El :attribute es obligatorio.',
            'correo.email' => 'El :attribute debe tener un formato válido.',
            'correo.max' => 'El :attribute no puede tener más de 255 caracteres.',
            'correo.unique' => 'El :attribute ya está en uso.',
            'correo.ends_with' => 'El :attribute debe terminar con "@ues.edu.sv".',
        ];
    }
}
