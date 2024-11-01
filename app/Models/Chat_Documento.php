<?php

namespace App\Models;
//
use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;
Use App\Models\Chat;

class Chat_Documento extends Model
{
    protected $table = 'chat_documentos';
    protected $fillable = ['id', 'id_documentos', 'id_chats','fecha_envio'];
    
    public function documento(){
        return $this->belongsTo(Documento::class, 'id_documentos');
    }

    public function chat(){
        return $this->belongsTo(Chat::class, 'id_chats');
    }
}
