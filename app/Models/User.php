<?php

namespace App\Models;

use App\Models\Loans;
use App\Models\Clients;
use App\Models\Portafolios;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
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
    ];

    public function portafolios(){
        return $this->hasMany(Portafolios::class);
    }

    public function portafoliosByDebtCollector(){
        return $this->hasMany(Portafolios::class, 'debt_colletor', 'id');
    }

    public function loans(){
        return $this->hasMany(Loans::class, 'user_id', 'id');
    }

    public function clients(){
        return $this->hasMany(Clients::class, 'user_id', 'id');
    }

    public function getLoansByPortafolio(){
        // Devuelve todos los prestamos relacionado a la cartera de un usuario, solo si se tiene la relaciones creadas.
        if($this->hasRole("Cobrador")){
            return $this->through('portafolios')->has('loans')->where("debt_colletor", $this->id);
        }

        return $this->through('portafolios')->has('loans');
    }
}
