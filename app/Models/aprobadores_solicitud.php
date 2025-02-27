<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class aprobadores_solicitud extends Model
{
    protected $table = 'aprobadores_solicitud';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Nivel',
        'IDAprobador',
        'IDReemplazo',
        'idSolicitudTipo',
        'Activo',
    ];
}
