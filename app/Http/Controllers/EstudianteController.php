<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controller
{
   
    public function create()
    {
        return view('estudiantes.create');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:estudiantes,email',
            'seccion' => 'required|string|max:50',
            'edad' => 'nullable|integer|min:18|max:60',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Estudiante::create($request->all());
        return redirect()->route('estudiantes.create')->with('success', 'Estudiante creado con éxito');
    }

    
    public function search(Request $request)
    {
        $query = Estudiante::query();

        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->has('seccion')) {
            $query->where('seccion', $request->seccion);
        }

        $estudiantes = $query->get();
        return view('estudiantes.index', compact('estudiantes'));
    }
}
