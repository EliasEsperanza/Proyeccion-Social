<?php

namespace App\Models;
//
use Illuminate\Database\Eloquent\Model;
use App\Models\Proyecto;

class Documento extends Model
{
    protected $table = 'documentos';
    protected $fillable = ['id', 'id_proyecto','tipo_documento','ruta_archivo','fecha_subida'];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
}
