<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class Historial_Departamentos extends Model
{
    protected $table = 'historial_departamentos';
    protected $fillable = ['id_departamento', 'accion', 'nombre_departamento'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

}