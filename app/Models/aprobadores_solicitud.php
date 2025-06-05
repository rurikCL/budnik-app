<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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


    protected function ActivoNombre(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ($attributes['Activo'] == 0) ? 'Inactivo' : (($attributes['Activo'] == 1) ? 'Activo' : 'Reemplazo'),
//            set: fn (string $value) => strtolower($value),
        );
    }
    protected function ActivoColor(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ($attributes['Activo'] == 0) ? 'danger' : (($attributes['Activo'] == 1) ? 'success' : 'warning'),
//            set: fn (string $value) => strtolower($value),
        );
    }
    public function aprobador(){
        return $this->hasOne(User::class,'id','IDAprobador');
    }
    public function reemplazo(){
        return $this->hasOne(User::class,'id','IDReemplazo');
    }
}
