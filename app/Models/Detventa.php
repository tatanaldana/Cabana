<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Apitrait;
use App\Traits\Token;

class Detventa extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='detventas';

    protected $allowincluded=['venta.user'];

    protected $fillable = [
        'nom_producto',
        'pre_producto',
        'cantidad',
        'subtotal',
        'venta_id',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

}