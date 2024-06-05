<?php

namespace App\Models;

use App\Models\Loans;
use App\Models\Clients;
use App\Models\Companies;
use App\Models\Portafolios;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

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

    public function companies(){
        return $this->hasMany(Companies::class, 'user_id', 'id');
    }

    public function portafolios()
    {
        return $this->hasMany(Portafolios::class);
    }

    public function portafoliosByDebtCollector(){
        return $this->hasMany(Portafolios::class, 'debt_collector', 'id');
    }

    public function getLoansByPortafolio(){
        
        // Obtener todas las compañías del usuario
        $companies = $this->companies()->with(['portafolios.loans.payments'])->get();

        // Recopilar todos los portafolios dependiendo del rol del usuario
        $portafolios = $companies->flatMap(function($company) {
            if ($this->hasRole("Cobrador")) {
                // Si es cobrador, obtener los portafolios asignados al cobrador dentro de la compañía
                return $company->portafolios->where('debt_collector', $this->id);
            } else {
                // Si no es cobrador, obtener todos los portafolios de la compañía
                return $company->portafolios;
            }
        });

        // Obtén todos los prestamos a través de los portafolios
        return $portafolios->flatMap(function($portafolio) {
            return $portafolio->loans;
        });
    }

    /*
     * This PHP code defines a method in the User class to retrieve clients associated with 
     * a specific portafolio by using Laravel relationships.
     */
    public function getClientsByPortafolio(){
        // f*king laravel relationships >:V...
        return $this->through('portafoliosByDebtCollector')->has('loans')->get()->map(function($loan){
            return $loan->client;
        });
    }
    
    public function getPaymentsByPortafolio()
    {
        // Obtener todas las compañías del usuario
        $companies = $this->companies()->with(['portafolios.loans.payments'])->get();

        // Recopilar todos los portafolios dependiendo del rol del usuario
        $portafolios = $companies->flatMap(function($company) {
            if ($this->hasRole("Cobrador")) {
                // Si es cobrador, obtener los portafolios asignados al cobrador dentro de la compañía
                return $company->portafolios->where('debt_collector', $this->id);
            } else {
                // Si no es cobrador, obtener todos los portafolios de la compañía
                return $company->portafolios;
            }
        });

        // Obtén todos los pagos a través de los portafolios y préstamos
        return $portafolios->flatMap(function($portafolio) {
            return $portafolio->loans->flatMap(function($loan) {
                return $loan->payments;
            });
        });
    }

    public function getClientByCompany()
    {
        return $this->through('companies')->has('clients')->get()->map(function($client){
            return $client;
        })->flatten();
    }

    public function getPortafoliosByCompany()
    {
        return $this->through('companies')->has('portafolios')->get()->map(function($portafolio){
            return $portafolio;
        })->flatten();
    }
    public function getLoansByCompany()
    {
        return $this->through('companies')->has('loans')->get()->map(function($loan){
            return $loan;
        })->flatten();
    }
}
