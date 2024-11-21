<?php

namespace App\Http\Controllers;

use App\Models\seccion_tutor;
use App\Models\User;
use Illuminate\Http\Request;

class seccion_tutorController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del Request
        $validated = $request->validate([
            'id_seccion' => 'required|exists:secciones,id_seccion',
            'id_tutor' => 'required|exists:users,id_usuario',
        ]);

        // Verificar que el usuario sea un tutor
        $tutor = User::find($validated['id_tutor']);
        if (!$tutor || $tutor->role !== 'Tutor') {
            return response()->json(['error' => 'El usuario especificado no es un tutor válido'], 422);
        }

        // Crear la relación entre el tutor y la sección
        $seccionTutor = seccion_tutor::create([
            'id_seccion' => $validated['id_seccion'],
            'id_tutor' => $validated['id_tutor'],
        ]);

        return response()->json([
            'message' => 'Tutor asignado correctamente a la sección',
            'data' => $seccionTutor,
        ], 201);
    }
}
