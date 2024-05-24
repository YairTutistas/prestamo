<?php

namespace App\Models;

use App\Models\Loans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PortafolioClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'portafolio_id',
        'client_id'
    ];

    public $timestamps = false;

    public function loans(){
        return $this->hasMany(Loans::class);
    }
}
