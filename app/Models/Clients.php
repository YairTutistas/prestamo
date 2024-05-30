<?php

namespace App\Models;

use App\Models\User;
use App\Models\Loans;
use App\Models\Portafolios;
use Database\Factories\ClientsFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type_document',
        'document',
        'phone',
        'email',
        'addresses',
        'department',
        'city',
        'neighborhood'
    ];

    public function loans(){
        return $this->hasMany(Loans::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function portafolio(){
        return $this->belongsTo(Portafolios::class);
    }
}
