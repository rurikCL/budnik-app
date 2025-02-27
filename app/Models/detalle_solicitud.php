<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detalle_solicitud extends Model
{
    protected $table = 'detalle_solicitud';
    protected $primaryKey = 'id';

    protected $fillable = [
        'IDSolicitud',
        'IDSolicitante',
        'IDRechazo',
        'Estado',
        'Descripcion',
        'DescUnidad',
        'Cantidad',
        'CostoUnitario',
        'CostoTotal',
        'CuentaContable',
        'UnidadNegocio',
        'CentroCosto',
        'SubCentro',
        'LugarFisico',
    ];

}
