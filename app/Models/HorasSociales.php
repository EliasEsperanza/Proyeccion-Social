<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorasSociales extends Model
{
    use HasFactory;
    
    protected $table = 'Horas_Sociales';
    protected $primaryKey= 'id_hora_social';
    protected $fillable = [
        'id_estudiante',
        'horas_completadas',
        'fecha_registro',
    ];

    public function estudiante(){
        return $this->belongsTo(Estudiante::class,'id_estudiante');
    }

    
}
