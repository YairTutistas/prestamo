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
        return $this->hasMany(Loans::class, 'client_id', 'id');
    }

    public function company(){
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }

    public function portafolio(){
        return $this->belongsTo(Portafolios::class);
    }

    // Funcion que obtiene todos los planes de pago asociados a los préstamos
    public function getPaymentPlans(){
        
        // Obtiene todos los préstamos junto con sus planes de pago relacionados
        $loans = $this->loans()->with('paymentPlans')->get();

        // Recorre cada préstamo y extrae sus planes de pago en una sola colección
        return $loans->flatMap(function($loan){
            return $loan->paymentPlans;
        });
    }
}
