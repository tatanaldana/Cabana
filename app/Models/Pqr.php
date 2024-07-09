<?php

namespace App\Models;

use App\Traits\Apitrait;
use App\Traits\Token;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pqr extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='pqrs';

    protected $allowincluded=['user'];

    protected $fillable = [
        'sugerencia',
        'tipo_suge',
        'estado',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
