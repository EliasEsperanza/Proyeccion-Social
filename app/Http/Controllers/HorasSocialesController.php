<?php

namespace App\Http\Controllers;

use App\Models\HorasSociales;
use Illuminate\Http\Request;

class HorasSocialesController extends Controller
{
    public function index(){
        $horas_sociales=HorasSociales::all();
        return view('horas_sociales.index',compact('horas_sociales'));
    }


    public function getHorasByEstudiantes($id_estudiante){
        $horas_sociales=HorasSociales::where('id_estudiante',$id_estudiante)->get();
        return view('horas_sociales.index',compact('horas_sociales'));
    }

    public function create()
    {
        return view("horas_sociales.create");
    }

    public function store(Request $request){
        $validacion = $request->validate([
            'id_estudiante' => 'required|integer',
            'horas_completadas' => 'required|integer|min:0',
            'fecha_registro'=> 'required|date',
        ]);

        HorasSociales::create($validacion);

        return redirect()->route('horas_sociales.index');
    }

    public function show(string $id)
    {
        $horas_sociales = HorasSociales::find($id);
        return view('horas_sociales.show', compact('horas_sociales'));
    }


    public function edit(string $id)
    {
        $horas_sociales = HorasSociales::find($id);

        if (!$horas_sociales) {
            return response()->json(['message' => 'Horas sociales no encontradas'], 404);
        }
        return view("horas_sociales.edit", compact('horas_sociales'));
    }


    public function update(Request $request, $id)
    {
        $validacion = $request->validate([
            'id_estudiante' => 'required|integer',
            'horas_completadas' => 'required|integer|min:0',
            'fecha_registro'=> 'required|date',
        ]);

        $horas_sociales = HorasSociales::find($id);

        if (!$horas_sociales) {
            return response()->json(['message' => 'Horas sociales no encontradas'], 404);
        }

        $horas_sociales->update($validacion);
        return response()->json($horas_sociales, 200);
    }


    public function destroy(string $id)
    {
        $horas_sociales = HorasSociales::find($id);
        if (!$horas_sociales) {
            return response()->json(['message' => 'Horas sociales no encontradas'], 404);
        }

        $horas_sociales->delete();
        return response()->json(['message' => 'Horas sociales eliminadas'], 200);
    }
}
