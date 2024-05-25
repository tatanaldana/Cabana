<?php

namespace App\Models;

use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matprima extends Model
{
    use HasFactory,Apitrait;

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
