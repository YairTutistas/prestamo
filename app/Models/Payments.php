<?php

namespace App\Models;

use App\Models\Loans;
use App\Models\Portafolios;
use App\Models\Payment_types;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_id',
        'amount',
        'payments_id',
        'payment_date'
    ];

    protected $casts = [
        'amount' => 'integer', // Convertir el campo 'amount' a un tipo numérico
    ];

    public function loan(){
        return $this->belongsTo(Loans::class);
    }

    public function getConsecutive()
    {
        return $this->count('loan_id');
    }

    public function paymentType(){
        return $this->belongsTo(Payment_types::class, 'payments_id', 'id');
    }
}
