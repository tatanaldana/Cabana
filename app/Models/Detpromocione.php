<?php

namespace App\Models;

use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detpromocione extends Model
{
    use HasFactory,Apitrait;

    protected $table='detpromociones';


    protected $fillable = [
        'cantidad',
        'descuento',
        'subtotal',
        'promociones_id',
        'productos_id',
    ];

    public function promocione(){
        return $this->belongsTo(Promocione::class);
    }
    
    public function producto(){
        return $this->belongsTo(Producto::class);
    }

}
