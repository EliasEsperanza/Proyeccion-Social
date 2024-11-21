<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class seccion_tutor extends Model
{
    protected $table = 'seccion_tutor';

    protected $fillable = [
        'id_seccion',
        'id_tutor',
    ];

    /**
     * Relación con el modelo Seccion.
     */
    public function seccion(): BelongsTo
    {
        return $this->belongsTo(Seccion::class, 'id_seccion', 'id_seccion');
    }

    /**
     * Relación con el modelo User (Tutor).
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_tutor', 'id_usuario');
    }
}
