<?php

namespace App\Models;

use App\Traits\Apitrait;
use App\Traits\Token;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='proveedores';

    protected $fillable = [
        'codigo',
        'nombre',
        'telefono',
        'direccion',
    ];
}
