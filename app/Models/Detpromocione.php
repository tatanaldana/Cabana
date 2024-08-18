<?php

namespace App\Models;

use App\Traits\Apitrait;
use App\Traits\Token;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detpromocione extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='detpromociones';

    protected $fillable = [
        'cantidad',
        'descuento',
        'subtotal',
        'promocione_id',
        'producto_id',
        'porcentaje'
    ];

    public function promocione(){
        return $this->belongsTo(Promocione::class);
    }
    
    public function producto(){
        return $this->belongsTo(Producto::class);
    }

}
