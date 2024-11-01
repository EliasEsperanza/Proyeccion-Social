<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proyecto;

class Estado extends Model
{
    use HasFactory;
    protected $table = 'Estados';
    protected $primaryKey= 'id_estado';



    protected $fillable =
    [
        'nombre_estado'
    ];

    //relaciones
    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    //gets

    public function get_estado_porId($id)
    {
        return self::find($id);
    }
    public function get_estados()
    {
        $estados = self::all();
        return $estados;
    }

}
