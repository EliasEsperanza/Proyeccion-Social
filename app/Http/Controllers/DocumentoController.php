<?php

namespace App\Http\Controllers;
//
use Illuminate\Http\Request;
use App\Models\Documento;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::all();
        return view('documentos.index', compact('documentos'));
    }

    public function create()
    {
        return view('documentos.create');
    }

    public function store(Request $request)
    {
        $documento = new Documento();
        $documento->id_proyecto = $request->id_proyecto;
        $documento->tipo_documento = $request->tipo_documento;
        $documento->ruta_archivo = $request->ruta_archivo;
        $documento->fecha_subida = $request->fecha_subida;
        $documento->save();
        return redirect()->route('documentos.index');
    }

    public function edit($id)
    {
        $documento = Documento::find($id);
        return view('documentos.edit', compact('documento'));
    }

    public function update(Request $request, $id)
    {
        $documento = Documento::find($id);
        $documento->id_proyecto = $request->id_proyecto;
        $documento->tipo_documento = $request->tipo_documento;
        $documento->ruta_archivo = $request->ruta_archivo;
        $documento->fecha_subida = $request->fecha_subida;
        $documento->save();
        return redirect()->route('documentos.index');
    }

    public function destroy($id)
    {
        $documento = Documento::find($id);
        $documento->delete();
        return redirect()->route('documentos.index');
    }
}
