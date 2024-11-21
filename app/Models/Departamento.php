<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Seccion;

class Departamento extends Model
{
  use HasFactory;
    protected $perPage = 20;

    protected $table = 'departamentos';
  //protected $table = 'departamentos_test';
    protected $fillable = ['id_departamento', 'nombre_departamento'];

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'id_departamento', 'id_departamento');
    }

}