<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class aprobaciones_solicitud extends Model
{
    protected $table = 'aprobaciones_solicitud';
    protected $primaryKey = 'id';

    protected $fillable = [
        'IDSolicitud',
        'IDAprobador',
        'Nivel',
        'Estado',
        'FechaAprobacion',
    ];
}
