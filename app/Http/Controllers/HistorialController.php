<?php

namespace App\Http\Controllers;

use App\Http\Requests\Historial\StoreRequest;
use App\Models\HistorialEstado;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    protected $historialEstado;

    public function __construct()
    {
        $this->historialEstado = new HistorialEstado();
    }

    public function index()
    {
        $historial = $this->historialEstado->all();
        return view('historial.index', compact('historial'));
    }

    /*
    * se necesita la tabla para ir guardando el horial delestado
    */
    
    public function store(StoreRequest $request)
    {

        $this->historialEstado->create($request->all());
        return redirect()->route('historial.index')->with('success', 'Cambio de estado registrado con éxito');
    }
}

