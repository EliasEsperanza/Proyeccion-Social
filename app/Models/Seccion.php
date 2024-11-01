<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Departamento; 

class Seccion extends Model 
{
    protected $perPage = 20;

    protected $table = 'Secciones';

    //columnas
    protected $fillable = ['id_seccion', 'nombre_seccion', 'id_departamento'];

    /**
     * Define una relación que pertenece al modelo Departamento.
     */
    public function departamento() 
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id'); 
    }
}
