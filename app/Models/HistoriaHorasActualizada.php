<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaHorasActualizada extends Model
{
    use HasFactory;

    protected $table = 'historias_horas_actualizadas';
    protected $primaryKey = 'id_horas_actualizadas';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'id_estudiante',
        'id_solicitud',
        'id_proyecto',
        'horas_aceptadas',
        'fecha_aceptacion',
    ];

    // Relación con Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante', 'id_estudiante');
    }

    // Relación con Solicitud
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'solicitud_id');
    }

    // Relación con Proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }
}
