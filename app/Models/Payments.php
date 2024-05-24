<?php

namespace App\Models;

use App\Models\Loans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount',
        'payment_date'
    ];

    protected $casts = [
        'amount' => 'integer', // Convertir el campo 'amount' a un tipo numérico
    ];

    public function loan(){
        return $this->belongsTo(Loans::class);
    }
}
