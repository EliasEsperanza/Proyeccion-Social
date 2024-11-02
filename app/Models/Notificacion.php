<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'Notificaciones';
    protected $primaryKey = 'id_notificacion';

    
    protected $fillable = [
        'id_usuario',
        'mensaje',
        'estado',
        'fecha_envio',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
