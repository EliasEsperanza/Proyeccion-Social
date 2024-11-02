<?php

namespace App\Http\Controllers;
//
use Illuminate\Http\Request;
use App\Models\Chat_Documento;

class ChatDocumentoController extends Controller
{
    public function index()
    {
        $chat_documentos = Chat_Documento::all();
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
        return redirect()->route('chat_documentos.index');
    }

    public function edit($id)
    {
        $chat_documento = Chat_Documento::find($id);
        return view('chat_documentos.edit', compact('chat_documento'));
    }

    public function update(Request $request, $id)
    {
        $chat_documento = Chat_Documento::find($id);
        $chat_documento->id_documentos = $request->id_documentos;
        $chat_documento->id_chats = $request->id_chats;
        $chat_documento->fecha_envio = $request->fecha_envio;
        $chat_documento->save();
        return redirect()->route('chat_documentos.index');
    }

    public function destroy($id)
    {
        $chat_documento = Chat_Documento::find($id);
        $chat_documento->delete();
        return redirect()->route('chat_documentos.index');
    }
}
