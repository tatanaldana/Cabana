<?php

namespace App\Models;

use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocione extends Model
{
    use HasFactory,Apitrait;

    protected $table='promociones';

    protected $allowincluded=['detpromociones'];

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
