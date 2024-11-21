<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles;
    use Notifiable;

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function seccionesCoordinadas()
    {
        return $this->hasMany(Seccion::class, 'id_coordinador');
    }

    // Secciones donde es tutor
    public function seccionesTutoreadas()
    {
        return $this->belongsToMany(
            Seccion::class,
            'seccion_tutor',
            'id_tutor',
            'id_seccion'
        );
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeAllTutores($query)
    {
        return $query->role('Tutor');
    }

    public function scopeEstudiantesPorSeccion(Builder $query)
    {
        return $query->role('Estudiante')
            ->leftJoin('estudiantes', 'users.id_usuario', '=', 'estudiantes.id_usuario')
            ->leftJoin('secciones', 'estudiantes.id_seccion', '=', 'secciones.id_seccion')
            ->orderBy('secciones.id_seccion')
            ->select('users.', 'secciones.nombre_seccion');
    }

    public function scopeTutoresPorSeccion(Builder $query)
    {
        return $query->role('Tutor')
            ->leftJoin('seccion_tutor', 'users.id_usuario', '=', 'seccion_tutor.id_tutor')
            ->leftJoin('secciones', 'seccion_tutor.id_seccion', '=', 'secciones.id_seccion')
            ->orderBy('secciones.id_seccion')
            ->select('users.', 'secciones.nombre_seccion')
            ->distinct();
    }

    public function scopeCoordinadoresPorSeccion(Builder $query)
    {
        return $query->role('Coordinador')
            ->leftJoin('secciones', 'users.id_usuario', '=', 'secciones.id_coordinador')
            ->orderBy('secciones.id_seccion')
            ->select('users.*', 'secciones.nombre_seccion');
    }

    public function scopeAdministradoresPorSeccion(Builder $query)
    {
        return $query->role('Administrador')
            ->select('users.*')
            ->orderBy('users.name');
    }

    //Obtener roles de cada usuario segun su id
    public static function rolesPorUsuario($id)
    {
        return self::find($id)->getRoleNames();
    }

    public static function UsuariosPorSeccion()
    {
        $estudiantes = self::estudiantesPorSeccion()->get();
        $tutores = self::tutoresPorSeccion()->get();
        $coordinadores = self::coordinadoresPorSeccion()->get();
        $administradores = self::AdministradoresPorSeccion()->get();

        return [
            'estudiantes' => $estudiantes,
            'tutores' => $tutores,
            'coordinadores' => $coordinadores,
            'administradores' => $administradores
        ];
    }
}

