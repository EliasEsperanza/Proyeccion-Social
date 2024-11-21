<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Solicitud extends Model
{
    protected $perPage = 20;

    protected $table = 'solicitudes';
    protected $primaryKey = 'solicitud_id';

    protected $fillable = ['id_estudiante', 'id_proyecto', 'valor', 'documento', 'estado'];
    
    
}