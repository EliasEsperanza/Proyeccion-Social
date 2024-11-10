<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estado;
use App\Models\User;



class Proyecto extends Model
{
    use HasFactory;
    protected $table = 'proyectos';
    protected $primaryKey= 'id_proyecto';


    protected $fillable =
    [
        'nombre_proyecto',
        'estado',
        'periodo',
        'lugar',
        'coordinador'
    ];

    //create
    public static function crearProyecto($data)
    {
        $validarCampos = validator($data, [
            'nombre_proyecto' => 'required|string|max:255',
            'estado' => 'required|integer',
            'periodo' => 'required|string|max:255',
            'lugar' => 'required|string|max:255',
            'coordinador' => 'required|integer',
            'fecha_inicio' => 'required|date',  
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ])->validate();

        return self::create($validarCampos);
    }

    //Relaciones a tabla estado y usuario
    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public static function AsignarFeechas($data)
    {
        return self::create($data);
    }

    public function coordinador()
    {

        return $this->belongsTo(user::class);
    }

    //gets
    public function getProyecto_porId($id)
    {
        return self::with('estado', 'coordinador')->find($id);
    }
    public function getProyecto_porNombre_estudiante($nombre_estudiante)
    {
        return self::with('estado', 'coordinador')->where('nombre_proyecto', $nombre_estudiante)->first();
    }
    public function getProyectos_porEstado($estadoId)
    {
        return self::with('estado', 'coordinador')->where('estado', $estadoId)->get();
    }
    public function getProyectos_porCoordinador($coordinadorId)
    {
        return self::with('estado', 'coordinador')->where('coordinador', $coordinadorId)->get();
    }
    public function getProyectos_porPeriodo($periodo)
    {
        return self::with('estado', 'coordinador')->where('periodo', $periodo)->get();
    }
}
