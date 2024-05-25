<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Apitrait;

class Detventa extends Model
{
    use HasFactory,Apitrait;

    protected $table='detventas';

    protected $allowincluded=['venta.user'];

    protected $fillable = [
        'nom_producto',
        'pre_producto',
        'cantidad',
        'subtotal',
        'ventas_id',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

}