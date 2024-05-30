<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    public function index(){
        $payments = Auth::user()->getPaymentsByPortafolio();
        // dd($payments);
        return view('payment.index', compact('payments'));
    }

    public function create(){
        $user = Auth::user();
        $loans = $user->getLoansByPortafolio;
        return view('payment.create', compact('loans'));
    }

    public function save(Request $request){
        $valueLoan = Loans::select('total_pay')->where('id', $request->loan_id)->first();
        $count = Payments::where('loan_id', $request->loan_id)->sum('amount');
        $resultDiff = ($count + $request->amount) - $valueLoan->total_pay;
        if ($count + $request->amount <= $valueLoan->total_pay) {
            $payment = new Payments();
            $payment->loan_id = $request->loan_id;
            $payment->amount =  $request->amount;
            $payment->user_id =  Auth::user()->id;
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
        if (Auth::user()->hasRole('Admin')) {
            $id = $this->decrypt($id);
            $payment = Payments::find($id);
            $payment->delete();
            return redirect()->route('payments')->with('status', 'Successfully deleted payment.');
        }
    }
}
