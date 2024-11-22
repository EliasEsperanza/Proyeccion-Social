<?php

namespace App\Models;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\Model;


class Seccion extends Model
{
    protected $perPage = 20;

    protected $table = 'secciones';
    protected $primaryKey = 'id_seccion';

    protected $fillable = ['nombre_seccion', 'id_departamento', 'id_coordinador'];

    /**
     * Define una relación que pertenece al modelo Departamento.
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id_departamento');

    }
    public function tutores()
    {
        return $this->belongsToMany(User::class, 'seccion_tutor', 'id_seccion', 'id_tutor');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'seccion_id', 'id_seccion');
    }
}