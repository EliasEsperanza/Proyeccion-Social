<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeccionTutor\StoreRequest;
use App\Models\seccion_tutor;
use App\Models\User;
use Illuminate\Http\Request;

class seccion_tutorController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        // Verificar que el usuario sea un tutor
        $tutor = User::find($request['id_tutor']);
        if (!$tutor || $tutor->role !== 'Tutor') {
            return response()->json(['error' => 'El usuario especificado no es un tutor válido'], 422);
        }

        // Crear la relación entre el tutor y la sección
        $seccionTutor = seccion_tutor::create($request->all());

        return response()->json([
            'message' => 'Tutor asignado correctamente a la sección',
            'data' => $seccionTutor,
        ], 201);
    }
}
