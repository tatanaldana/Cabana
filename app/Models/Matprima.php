<?php

namespace App\Models;

use App\Traits\Apitrait;
use App\Traits\Token;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matprima extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='matprimas';

    protected $fillable = [
        'referencia',
        'descripcion',
        'existencia',
        'entrada',
        'salida',
        'stock',
    ];
}
