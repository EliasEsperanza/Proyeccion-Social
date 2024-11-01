<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    
    protected $table = 'Estudiantes';
    protected $fillable = [
        'id_usuario',
        'id_seccion',
        'porcentaje_completado',
        'horas_sociales_completadas'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'id_seccion');
    }
}
