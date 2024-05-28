<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index(){
        $payments = Payments::all();

        return view('payment.index', compact('payments'));
    }

    public function create(){
        $loans = Loans::all();
        return view('payment.create', compact('loans'));
    }

    public function save(Request $request){
        $valueLoan = Loans::select('total_pay')->where('id', $request->loan_id)->first();
        $count = Payments::where('loan_id', $request->loan_id)->sum('amount');
        $resultDiff = ($count + $request->amount) - $valueLoan->total_pay;
        if ($count + $request->amount <= $valueLoan->total_pay) {
            $payment = new Payments();
            $payment->loan_id = $request->loan_id;
            $payment->amount =  (int)$request->amount;
            $payment->payment_date = $request->payment_date;
            $payment->save();
            return redirect()->route('payments')->with('status', 'Successfully created payment.');
        }else {
            return redirect()->route('createPayment')->with('status', 'The amount borrowed has been exceeded by. '. $resultDiff);
        }
    }

    public function show($id){
        $payment = Payments::all();
        return $payment;
    }

    public function update(){

    }

    public function delete($id){
        $payment = Payments::find($id);
        $payment->delete();
        return redirect()->route('payments')->with('status', 'Successfully deleted payment.');
    }
}
