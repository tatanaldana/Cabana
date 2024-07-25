<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Apitrait;
use App\Traits\Token;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Apitrait,HasRoles,Token;

    public $incrementing=false;
    protected $primaryKey = 'id'; 
    protected $table='users';

    protected $allowincluded=['ventas','pqrs','ventas.detventas'];
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'tipo_doc',
        'tel',
        'fecha_naci',
        'genero',
        'direccion',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

        //relacion uno a muchos
        public function pqrs(){
            return $this->hasMany(Pqr::class);
        }
    
        public function ventas(){
            return $this->hasMany(Venta::class);
        }
    
       /*public function role(){
            return $this->belongsTo(Role::class);
        }*/

        public function image()
        {
            return $this->morphOne(Image::class, 'imageable');
        }

        public function findForPassport(string $email): User
        {
            return $this->where('email', $email)->first();
        }

        public function validateForPassportPasswordGrant(string $password): bool
        {
            return Hash::check($password, $this->password);
        }

}
