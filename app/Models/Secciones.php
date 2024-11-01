<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Departamentos;
class Secciones extends Model
{
    protected $perPage = 20;

    //tabla
    protected $fillable = ['id_seccion', 'nombre_seccion', 'id_departamento'];

    /**
     * Define una relación que pertenece al  modelo Departamentos.
    */
    public function Departamento()
    {
        return $this->belongsTo(Departamentos::class, 'id_departamento', 'id');
    }
}
