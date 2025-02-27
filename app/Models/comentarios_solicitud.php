<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comentarios_solicitud extends Model
{
    protected $table = 'comentarios_solicitud';
    protected $primaryKey = 'id';

    protected $fillable = [
        'IDSolicitud',
        'IDUsuario',
        'Comentario',
    ];
}
