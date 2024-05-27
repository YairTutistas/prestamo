<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment_plans;

class PaymentPlansController extends Controller
{
    public function save(Request $request, $loan){
        $paymentPlan = new Payment_plans();
        $paymentPlan->loan_id = $loan;
        $paymentPlan->quota = $request->quota;
        $paymentPlan->payment_date = $request->payment_date;
        $paymentPlan->save();
    }
}
