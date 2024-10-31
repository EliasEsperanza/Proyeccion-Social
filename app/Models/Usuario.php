<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table ='Usuarios';
    protected $primaryKey= 'id_usuario';
    public $timestamps= false;

    protected $fillable=['nombre','correo','rol','password'];


    //Relacion con la tabla Chats
    public function ChatEmisor(){
        return $this->hasMany(Chat::class, 'id_emisor','id_usuario');
    }

    public function ChatReceptor(){
        return $this->hasMany(Chat::class,'id_receptor');
    }

    //Relacion con la tabla NOtificaciones
    public function notificaciones(){
        return $this->hasMany(Notificacion::class,'id_usuario');
    }
    //Relacion con la tabla Estudiantes
    public function Estudiantes(){
        return $this->hasOne(Estudiante::class,'id_usuario');
    }

    //Relacion con la tabla estado
    public function Estado(){
        return $this->belongsTo(Estado::class,'rol','id_usuario');
    }
}
