<?php

namespace App\Models;

use App\Models\Loans;
use App\Models\Companies;
use App\Models\Portafolios;
use Database\Factories\ClientsFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clients extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
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

    public function company(){
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }

    public function portafolio(){
        return $this->belongsTo(Portafolios::class);
    }
}
