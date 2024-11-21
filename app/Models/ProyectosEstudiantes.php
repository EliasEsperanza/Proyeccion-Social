<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proyecto;
use App\Models\Estudiante;

class ProyectosEstudiantes extends Model
{
    use HasFactory;
    protected $table = 'proyectos_estudiantes';
    protected $primaryKey= 'id_proyectos_estudiante';
    protected $fillable = [
        'id_proyecto',
        'id_estudiante',
    ];

    public function proyecto(){
        return $this->belongsTo(Proyecto::class,'id_proyecto');
    }

    public function estudiantes(){
        return $this->belongsToMany(Estudiante::class,'id_estudiante');
    }
}
