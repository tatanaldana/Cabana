<?php

namespace App\Models;

use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory,Apitrait;

    protected $table='roles';

    protected $allowincluded=['users'];

    protected $fillable = [
        'nombre',
        
    ];

    //relacion uno a muchos
    public function users(){
        return $this->hasMany(User::class);
    }


}
