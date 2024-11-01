<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Seccion;
class Departamento extends Model
{
    protected $perPage = 20;

    protected $table = 'departamentos';

    protected $fillable = ['id_departamento', 'nombre_departamento'];

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'id_departamento', 'id_departamento');
    }
}
