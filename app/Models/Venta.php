<?php

namespace App\Models;

use App\Traits\Token;
use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='ventas';

    protected $allowincluded=['detventas','user'];

    
    protected $fillable = [
        'metodo_pago',
        'estado',
        'total',
        'users_doc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        //relacion uno a muchos
    public function detventas(){
        return $this->hasMany(Detventa::class);
    }   

}
