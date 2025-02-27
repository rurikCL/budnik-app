<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentos_solicitud extends Model
{
    protected $table = 'documentos_solicitud';
    protected $primaryKey = 'id';

    protected $fillable = [
        'IDSolicitud',
        'NombreArchivo',
        'Descripcion',
        'TipoArchivo',
        'TipoDocumento',
        'Estado',
        'Path',
        'AsociadoA',
    ];
}
