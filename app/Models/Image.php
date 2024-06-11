<?php

namespace App\Models;

use App\Traits\Apitrait;
use App\Traits\Token;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory,Apitrait,Token;

    protected $table='images';

    protected $fillable=[
        'imageable_id',
        'imageable_type',
        'path'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}

