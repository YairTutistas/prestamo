<?php

namespace App\Models;

use App\Models\User;
use App\Models\Loans;
use App\Models\Clients;
use App\Models\Portafolios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Companies extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function portafolios(){
        return $this->hasMany(Portafolios::class, 'company_id', 'id');
    }

    public function loans(){
        return $this->hasMany(Loans::class, 'company_id', 'id');
    }

    public function clients(){
        return $this->hasMany(Clients::class, 'company_id', 'id');

    }
}
