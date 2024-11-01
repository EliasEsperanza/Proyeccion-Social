<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    
    protected $table = 'Notificaciones';
    protected $primaryKey = 'id_notificacion';

    // Deshabilitar timestamps automáticos si no se utilizan
    public $timestamps = false;

    
    protected $fillable = [
        'id_usuario',
        'mensaje',
        'estado',
        'fecha_envio',
    ];

    
    public function user()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
