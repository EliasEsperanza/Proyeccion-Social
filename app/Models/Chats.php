<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $table = 'Chats';
    protected $fillable = ['id_emisor', 'id_receptor', 'mensaje'];
    
    public function emisor()
    {
        return $this->belongsTo(User::class, 'id_emisor');
    }

    public function recibidor()
    {
        return $this->belongsTo(User::class, 'id_recibidor');
    }
}
