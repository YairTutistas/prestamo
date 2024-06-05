<?php

namespace App\Models;

use App\Models\User;
use App\Models\Loans;
use App\Models\Clients;
use App\Models\Companies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portafolios extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'debt_collector',
        'company_id',
    ];

    public function company(){
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }
    
    public function getDebtCollector(){
        return $this->belongsTo(User::class, 'debt_collector', 'id');
    }
    
    public function loans(){
        return $this->hasMany(Loans::class, 'portafolio_id', 'id');
    }

    public function getClientsByLoans()
    {
        // f*king laravel relationships >:V...
        return $this->belongsToMany(Clients::class, "loans", 'portafolio_id', 'client_id');
    }

    public function getPaymentsByLoans($user_id){
        return $this->where("user_id". $user_id);
    }

}
