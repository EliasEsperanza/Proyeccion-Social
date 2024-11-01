<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//Tienes que usar el use para llamar a la clase User y la clase Seccion.
//No se usara una clase Usuario, ya que se utilizara la clase User de Laravel.

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
