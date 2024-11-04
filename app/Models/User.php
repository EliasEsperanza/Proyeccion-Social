<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}