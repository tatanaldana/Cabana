<?php

namespace App\Models;

use App\Traits\Apitrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory,Apitrait;

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

