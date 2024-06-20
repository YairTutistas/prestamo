<?php

namespace App\Models;

use App\Models\Loans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment_plans extends Model
{
    use HasFactory, SoftDeletes;
    
    public $fillable = [
        'loan_id',
        'quota',
        'indivudual_value',
        'payment_date'
    ];

    public function loan(){
        return $this->belongsTo(Loans::class);
    }
    
}
