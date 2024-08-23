<?php

namespace App\Models;

use App\Traits\Token;
use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='ventas';

    protected $allowincluded=['detventas','user'];

    
    protected $fillable = [
        'metodo_pago',
        'estado',
        'total',
        'medio_env',
        'user_id',
        'address_ventas',
    ];

    protected function estado(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? 'Completado' : 'En Proceso',
            set: fn ($value) => $value === 'Completado' ? 1 : 0
        );
    }

    protected function medioEnv(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? 'A domicilio' : 'En tienda',
            set: fn ($value) => $value === 'A domicilio' ? 1 : 0
        );
    }

    protected function address_ventas(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value === 'null' || $value === null ? "Entrega en punto" : $value,
            set: fn ($value) => $value === 'null' || $value === null ? "Entrega en punto" : $value
        );
    }
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        //relacion uno a muchos
    public function detventas(){
        return $this->hasMany(Detventa::class);
    }   

}
