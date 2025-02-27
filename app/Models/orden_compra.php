<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class orden_compra extends Model
{
    protected $table = 'orden_compra';
    protected $primaryKey = 'id';

    protected $fillable = [
        'IDSolicitante',
        'IDSolicitudCompra',
        'Estado',
        'Descripcion',
        'Comentario',
        'FechaSolicitud',
    ];

    protected function EstadoNombre(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ($attributes['Estado'] == 0) ? 'Pendiente' : (($attributes['Estado'] == 1) ? 'Aprobado' : 'Rechazado'),
//            set: fn (string $value) => strtolower($value),
        );
    }
    public function solicitante(){
        return $this->hasOne(User::class, 'id','IDSolicitante');
    }

    public function solicitudCompra(){
        return $this->hasOne(solicitudes_compra::class, 'id','IDSolicitudCompra');
    }

    public function aprobaciones(){
        return $this->hasMany(aprobaciones_solicitud::class,'IDSolicitud','id');
    }
}
