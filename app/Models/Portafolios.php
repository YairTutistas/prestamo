<?php

namespace App\Models;

use App\Models\User;
use App\Models\Loans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portafolios extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_rol',
        'user_id',
    ];

    public function userRol(){
        return $this->belongsTo(User::class, 'user_rol', 'id');
    }

    public function userId(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function loans(){
        return $this->hasMany(Loans::class, 'portafolio_id', 'id');
    }

}
