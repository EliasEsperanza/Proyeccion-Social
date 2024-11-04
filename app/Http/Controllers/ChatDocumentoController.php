<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat_Documento;
use Illuminate\Support\Facades\Validator;

class ChatDocumentoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has(['id_documentos', 'id_chats', 'fecha_envio'])) {
            return $this->search($request);
        }

        // Aplicando la paginación si no hay búsqueda
        $chat_documentos = Chat_Documento::paginate(20);
        
        return view('chat_documentos.index', compact('chat_documentos'));
    }

    public function create()
    {
        return view('chat_documentos.create');
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id_documentos' => 'required|exists:documentos,id',
            'id_chats' => 'required|exists:chats,id',
            'fecha_envio' => 'required|date',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $chat_documento = new Chat_Documento();
        $chat_documento->id_documentos = $request->id_documentos;
        $chat_documento->id_chats = $request->id_chats;
        $chat_documento->fecha_envio = $request->fecha_envio;
        $chat_documento->save();

        return redirect()->route('chat_documentos.index')
            ->with('success', 'Documento enviado correctamente al chat.');
    }

    public function edit($id)
    {
        $chat_documento = Chat_Documento::find($id);
        return view('chat_documentos.edit', compact('chat_documento'))
            ->with('info', 'Puedes editar el documento seleccionado.');
    }

    public function update(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'id_documentos' => 'required|exists:documentos,id',
            'id_chats' => 'required|exists:chats,id',
            'fecha_envio' => 'required|date',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        $chat_documento = Chat_Documento::find($id);
        $chat_documento->id_documentos = $request->id_documentos;
        $chat_documento->id_chats = $request->id_chats;
        $chat_documento->fecha_envio = $request->fecha_envio;
        $chat_documento->save();

        return redirect()->route('chat_documentos.index')
            ->with('success', 'Documento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $chat_documento = Chat_Documento::find($id);
        $chat_documento->delete();

        return redirect()->route('chat_documentos.index')
            ->with('success', 'Documento eliminado correctamente.');
    }

    public function search(Request $request)
    {
        $id_documentos = $request->input('id_documentos');
        $id_chats = $request->input('id_chats');
        $fecha_envio = $request->input('fecha_envio'); 

        $query = Chat_Documento::query();

        if ($id_documentos) {
            $query->where('id_documentos', $id_documentos);
        }
        if ($id_chats) {
            $query->where('id_chats', $id_chats);
        }
        if ($fecha_envio) {
            $query->whereDate('fecha_envio', $fecha_envio);
        }

        $chat_documentos = $query->get();

        return view('chat_documentos.index', compact('chat_documentos'));
    }
}
