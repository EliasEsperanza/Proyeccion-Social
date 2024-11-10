<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Documento::query();

        // Filtro por proyecto
        if ($request->has('id_proyecto') && !empty($request->id_proyecto)) {
            $query->where('id_proyecto', $request->id_proyecto);
        }

        // Filtro por tipo de documento
        if ($request->has('tipo_documento') && !empty($request->tipo_documento)) {
            $query->where('tipo_documento', 'like', '%' . $request->tipo_documento . '%');
        }

        // Paginación
        $documentos = $query->paginate(10);

        return view('documentos.index', compact('documentos'));
    }

    public function create()
    {
        return view('documentos.create');
    }

    /**
     * Almacenar un nuevo documento con validación de archivo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt|max:2048', // Máximo 2 MB
            'id_proyecto' => 'required|integer',
            'tipo_documento' => 'required|string|max:255',
        ]);

        if ($request->file('file')->isValid()) {
            // Guarda el archivo en el directorio `documentos`
            $filePath = $request->file('file')->store('documentos', 'public');

            // Guarda el registro en la base de datos
            $documento = new Documento();
            $documento->id_proyecto = $request->id_proyecto;
            $documento->tipo_documento = $request->tipo_documento;
            $documento->ruta_archivo = $filePath;
            $documento->fecha_subida = now();
            $documento->save();

            return redirect()->route('documentos.index')->with('success', 'Documento subido correctamente.');
        }

        return redirect()->back()->withErrors(['file' => 'Error al subir el archivo']);
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
        
        // Opcionalmente se puede permitir actualizar el archivo
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $request->validate([
                'file' => 'file|mimes:pdf,doc,docx,txt|max:2048',
            ]);

            // Eliminar archivo antiguo
            Storage::disk('public')->delete($documento->ruta_archivo);

            // Guardar nuevo archivo
            $filePath = $request->file('file')->store('documentos', 'public');
            $documento->ruta_archivo = $filePath;
        }

        $documento->fecha_subida = now();
        $documento->save();

        return redirect()->route('documentos.index')->with('success', 'Documento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $documento = Documento::find($id);

        // Elimina el archivo de almacenamiento
        Storage::disk('public')->delete($documento->ruta_archivo);

        // Elimina el registro de la base de datos
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado correctamente.');
    }

    /**
     * Descargar un documento por su ID.
     */
    public function download($id)
    {
        $documento = Documento::findOrFail($id);

        if (Storage::disk('public')->exists($documento->ruta_archivo)) {
            return Storage::disk('public')->download($documento->ruta_archivo, $documento->tipo_documento . '.' . pathinfo($documento->ruta_archivo, PATHINFO_EXTENSION));
        }

        return redirect()->route('documentos.index')->withErrors(['file' => 'Archivo no encontrado']);
    }
}
