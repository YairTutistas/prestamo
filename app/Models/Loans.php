<?php

namespace App\Models;

use App\Models\Clients;
use App\Models\Payments;
use App\Models\Companies;
use App\Models\Portafolios;
use App\Models\Payment_plans;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loans extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'portafolio_id',
        'company_id',
        'client_id',
        'amount',
        'payment_method',
        'total_pay',
        'interest_rate',
        'deadlines',
        'quota_value',
        'flag',
        'start_date',
        'end_date',
    ];

    public function client(){
        return $this->belongsTo(Clients::class);
    }

    public function company(){
        return $this->belongsTo(Companies::class);
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

    public function getValidatePaymethod($data){
        $paymentMethod = '';
        switch ($data) {
            case '1':
                $paymentMethod = 'Diario';
                break;
            case '2':
                $paymentMethod = 'Semanal';
                break;
            case '3':
                $paymentMethod = 'Quincenal';
                break;
            case '4':
                $paymentMethod = 'Mensual';
                break;
            
            default:
                # code...
                break;
        }

        return $paymentMethod;
    }
}
