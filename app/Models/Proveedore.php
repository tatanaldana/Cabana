<?php

namespace App\Models;

use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory,Apitrait;

    protected $table='proveedores';

    protected $fillable = [
        'codigo',
        'nombre',
        'telefono',
        'direccion',
    ];
}
