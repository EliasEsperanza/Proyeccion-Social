<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigosRecuperacion extends Model
{
  use HasFactory;

    protected $table = 'codigos_recuperacion';
    protected $primaryKey = 'id_codigo';
    protected $fillable = ['codigo'];
    public $timestamps = false;

}