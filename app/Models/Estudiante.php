<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Seccion;
use App\Models\Proyecto;
use App\Models\ProyectosEstudiantes;


class Estudiante extends Model
{
    use HasFactory;
    
    protected $table = 'estudiantes';
    protected $primaryKey = 'id_estudiante';
    protected $fillable = [
        'id_usuario',
        'id_seccion',
        'porcentaje_completado',
        'horas_sociales_completadas'
    ];

    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'id_seccion');
    }
    public function proyecto()
    {
        return $this->hasOneThrough(Proyecto::class,ProyectosEstudiantes::class, 'id_estudiante','id_proyecto','id_estudiante','id_proyectos_estudiante');
    }
}
