<?php

namespace App\Models;

use App\Models\Payments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment_types extends Model
{
    use HasFactory;

    protected $fillaboe = [
        'name',
    ];

    public function payments(){
        return $this->hasMany(Payments::class);
    }
}
