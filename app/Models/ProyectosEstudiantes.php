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
    protected $primaryKey= 'id';
    protected $fillable = [
        'id_proyectos',
        'id_estudiantes',
    ];

    public function proyecto(){
        return $this->belongsTo(Proyecto::class,'id_proyectos');
    }

    public function estudiantes(){
        return $this->belongsToMany(Estudiante::class,'id_estudiantes');
    }
}
