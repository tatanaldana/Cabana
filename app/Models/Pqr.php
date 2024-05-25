<?php

namespace App\Models;

use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pqr extends Model
{
    use HasFactory,Apitrait;

    protected $table='pqrs';

    protected $allowincluded=['user'];

    protected $fillable = [
        'sugerencia',
        'tipo_suge',
        'estado',
        'users_doc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
