<?php

namespace App\Models;

use App\Traits\Apitrait;
use App\Traits\Token;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocione extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='promociones';

    protected $allowincluded=['detpromociones','detpromociones.producto'];

    protected $fillable = [
        'nom_promo',
        'total_promo',
        'categorias_id',
    ];

    public function detpromociones(){
        return $this->hasMany(Detpromocione::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

}
