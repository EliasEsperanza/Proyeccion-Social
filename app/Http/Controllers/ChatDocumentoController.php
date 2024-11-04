<?php

namespace App\Http\Controllers;
//
use Illuminate\Http\Request;
use App\Models\Chat_Documento;

class ChatDocumentoController extends Controller
{
    public function index()
    {
        //aplicando la paginacion
        $chat_documentos = Chat_Documento::paginate(20);
        return view('chat_documentos.index', compact('chat_documentos'));
    }

    public function create()
    {
        return view('chat_documentos.create');
    }

    public function store(Request $request)
    {
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
        ->with('info', 'Puedes editar el documento seleccionado.');;
    }

    public function update(Request $request, $id)
    {
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
}
