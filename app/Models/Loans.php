<?php

namespace App\Models;

use App\Models\User;
use App\Models\Clients;
use App\Models\Payments;
use App\Models\Portafolios;
use App\Models\Payment_plans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loans extends Model
{
    use HasFactory;

    protected $fillable = [
        'portafolio_id',
        'user_id',
        'client_id',
        'amount',
        'payment_method',
        'total_pay',
        'interest_rate',
        'deadlines',
        'quota_value',
        'start_date',
        'end_date',
    ];

    public function client(){
        return $this->belongsTo(Clients::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function payments(){
        return $this->hasMany(Payments::class, 'loan_id', 'id');
    }

    public function portafolio(){
        return $this->belongsTo(Portafolios::class);
    }

    public function getTotalPayments(){
        $payments = $this->payments->sum('amount');
        return $payments;
    }
    
    public function paymentPlans(){
        return $this->hasMany(Payment_plans::class, 'loan_id', 'id');
    }
}
