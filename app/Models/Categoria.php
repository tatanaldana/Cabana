<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Apitrait;


class Categoria extends Model
{
    use HasFactory,Apitrait;

    protected $table='categorias';

    protected $allowincluded=['productos','productos.detpromociones'];

    protected $allowfilter=['nombre_cat','id'];

    protected $allowsort=['nombre_cat','id'];
            /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_cat',

    ];

    //relacion uno a muchos
    public function productos(){
        return $this->hasMany(Producto::class);
    }

    public function promociones(){
        return $this->hasMany(Promocione::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }
//mopdificar query con el emetodo incluided

}
