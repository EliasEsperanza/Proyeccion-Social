<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';
    protected $primaryKey = 'id_proyecto';

    protected $fillable = [
        'nombre_proyecto',
        'descripcion_proyecto',
        'horas_requeridas',
        'estado',
        'periodo',
        'lugar',
        'coordinador',
        'tutor',
        'fecha_inicio',
        'fecha_fin',
        'seccion_id'
    ];


    protected $with = ['estadoo', 'coordinadorr'];

    private static $rules = [
        'nombre_proyecto' => 'required|string|max:255',
        'descripcion_proyecto' => 'required|string',
        'horas_requeridas' => 'required|integer',
        'estado' => 'required|exists:estados,id_estado',
        'periodo' => 'required|string|max:255',
        'lugar' => 'required|string|max:255',
        'coordinador' => 'required|exists:users,id_usuario',
        'tutor' => 'nullable|exists:users,id_usuario', 
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ];
// En el modelo Seccion.php
public function seccion()
{
    return $this->belongsTo(Seccion::class, 'seccion_id', 'id_seccion');
}
public function departamento()
{
    return $this->belongsTo(Departamento::class, 'id_departamento');
}
    //Relaciones a tabla estado y usuario
    public function estadoo()
    {
        return $this->belongsTo(Estado::class,'estado','id_estado', 'estado', 'id_estado');
    }

    public function coordinadorr()
    {
        return $this->belongsTo(User::class, 'coordinador', 'id_usuario');
    }

    public function tutorr()
    {
        return $this->belongsTo(User::class,'tutor','id_usuario');

    }

    public function scopePorEstado(Builder $query, $estadoId)
    {
        return $query->where('estado', $estadoId);
    }

    public function scopePorCoordinador(Builder $query, $coordinadorId)
    {
        return $query->where('coordinador', $coordinadorId);
    }

    public function scopePorPeriodo(Builder $query, $periodo)
    {
        return $query->where('periodo', $periodo);
    }

    public function scopeActivos(Builder $query)
    {
        return $query->whereDate('fecha_fin', '>=', now());
    }

    public function scopeConTutor(Builder $query)
    {
        return $query->whereNotNull('tutor');
    }

    public function scopeSinTutor(Builder $query)
    {
        return $query->whereNull('tutor');
    }

    public static function crearProyecto(array $data)
    {
        $validatedData = self::validarDatos($data);
        return self::create($validatedData);
    }

    public static function actualizarProyecto($id, array $data)
    {
        $proyecto = self::findOrFail($id);
        $validatedData = self::validarDatos($data);
        $proyecto->update($validatedData);
        return $proyecto->fresh();
    }

    public function asignarTutor($tutorId)
    {
        if ($tutorId) {
            Validator::make(['tutor' => $tutorId], [
                'tutor' => 'exists:users,id_usuario'
            ])->validate();
        }
        
        $this->update(['tutor' => $tutorId]);
        return $this->fresh();
    }

    public function removerTutor()
    {
        $this->update(['tutor' => null]);
        return $this->fresh();
    }

    public static function obtenerPorId($id)
    {
        return self::findOrFail($id);
    }

    public static function obtenerPorNombreEstudiante($nombre)
    {
        return self::where('nombre_proyecto', 'LIKE', "%{$nombre}%")->first();
    }

    public static function listarPorEstado($estadoId)
    {
        return self::porEstado($estadoId)->get();
    }

    public static function listarPorCoordinador($coordinadorId)
    {
        return self::porCoordinador($coordinadorId)->get();
    }
    public function listarPorPeriodo($periodo)
    {
        return self::porPeriodo($periodo)->get();
    }
    private static function validarDatos(array $data)
    {
        $validator = Validator::make($data, self::$rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'proyectos_estudiantes', 'id_proyecto', 'id_estudiante');
    }

    public function estaActivo(): bool
    {
        return $this->fecha_fin >= now();
    }

    public function tieneTutor(): bool
    {
        return !is_null($this->tutor);
    }

    public function getDuracionEnDias(): int
    {
        return now()->parse($this->fecha_inicio)->diffInDays($this->fecha_fin);
    }

    public function getProgresoEnPorcentaje(): float
    {
        $totalDias = $this->getDuracionEnDias();
        $diasTranscurridos = now()->parse($this->fecha_inicio)->diffInDays(now());
        return min(100, ($diasTranscurridos / $totalDias) * 100);
    }
}