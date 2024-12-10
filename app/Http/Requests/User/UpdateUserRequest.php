<?php

namespace App\Http\Requests\User; 

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'rol' => 'required|string|exists:roles,name',
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
            'password' => 'Contraseña',
            'rol' => 'Rol de usuario',
            'id_seccion' => 'Sección',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.exists' => 'El rol seleccionado no existe.',
            'id_seccion.exists' => 'La sección seleccionada no existe.',
        ];
    }
}
