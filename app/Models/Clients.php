<?php

namespace App\Models;

use App\Models\Loans;
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
}
