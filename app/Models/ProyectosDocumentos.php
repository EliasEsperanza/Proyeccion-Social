<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;
use App\Models\Proyecto;

class ProyectosDocumentos extends Model
{
    protected $table = 'proyectos_documentos';
    protected $fillable = ['id_documento', 'id_proyecto'];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'id_documento');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
}
