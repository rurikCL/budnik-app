<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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


    protected function EstadoNombre(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ($attributes['Estado'] == 0) ? 'Pendiente' : (($attributes['Estado'] == 1) ? 'Aprobado' : 'Rechazado'),
//            set: fn (string $value) => strtolower($value),
        );
    }
    protected function EstadoColor(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ($attributes['Estado'] == 0) ? 'info' : (($attributes['Estado'] == 1) ? 'success' : 'danger'),
        );
    }
    protected function EstadoIcono(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ($attributes['Estado'] == 0) ? 'heroicon-o-clock' : (($attributes['Estado'] == 1) ? 'heroicon-o-check-circle' : 'heroicon-o-x-mark'),
        );
    }
    public function aprobador(){
        return $this->hasOne(User::class,'id','IDAprobador');
    }
}
