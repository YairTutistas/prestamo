<?php

namespace App\Models;

use App\Models\User;
use App\Models\Loans;
use App\Models\Clients;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portafolios extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'debt_collector',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function getDebtCollector(){
        return $this->belongsTo(User::class, 'debt_collector', 'id');
    }
    
    public function loans(){
        return $this->hasMany(Loans::class, 'portafolio_id', 'id');
    }

    public function getClient(){
        dd($this->hasManyThrough(Clients::class, Loans::class, 'client_id', 'portafolio_id'));
    }

}
