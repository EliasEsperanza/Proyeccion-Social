<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasAnyRole(['Administrador', 'Coordinador']);
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'id_seccion' => 'nullable|exists:secciones,id_seccion',
        ];
    }

    /**
     * 
     * Nombres de los atributos
     */

    public function attributes(): array
    {
        return [
            'nombre' => 'Nombre completo',
            'correo' => 'Dirección de correo electronico.',
            'password' => 'Contraseña',
            'id_seccion' => 'Sección',
        ];
    }

    /**
     * 
     * Mensajes de feedback
     */

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser válido.',
            'correo.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'id_seccion.exists' => 'La sección seleccionada no existe.',
        ];
    }
}
