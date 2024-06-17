<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Payments;
use App\Models\Payment_types;
use App\Models\Payment_plans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentsController extends Controller
{
    public function index(){
        $payments = Auth::user()->getPaymentsByPortafolio();
        return view('payment.index', compact('payments'));
    }

    public function create(){
        $user = Auth::user();
        $loans = $user->getLoansByPortafolio()->where('status', 1);
        $paymentTypes = Payment_types::all();
        return view('payment.create', compact('loans', 'paymentTypes'));
    }

    public function save(Request $request){
        // dd($request);
        $loan_id = $this->decrypt($request->loan_id);
        $paymentType_id = $this->decrypt($request->paymentType_id);
        $valueLoan = Loans::select('total_pay')->where('id', $loan_id)->first();
        $valueQuota = Payment_plans::select('indivudual_value')->where('loan_id', $loan_id)->first();
        // $LastValueQuota = Payments::select('amount')->where('loan_id', $loan_id)->get()->last();
        $count = Payments::where('loan_id', $request->loan_id)->sum('amount');
        $resultDiff = ($count + $request->amount) - $valueLoan->total_pay;
        
        if ($request->amount < $valueQuota->indivudual_value) {
            
        } else {
            $paymentPlan = Payment_plans::where('loan_id', $loan_id)->where('status', 1)->first();
            $paymentPlan->status = 2;
            $paymentPlan->save();
        }

        if ($count + $request->amount <= $valueLoan->total_pay) {
            $payment = new Payments();
            $payment->loan_id = $loan_id;
            $payment->payments_id = $paymentType_id;
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
        $id = $this->decrypt($id);
        $payment = Payments::find($id);
        $payment->delete();
        return redirect()->route('payments')->with('status', 'Successfully deleted payment.');
    }

    public function generateInvoice($payment_id)
    {
        $id = $this->decrypt($payment_id);
        $payment = Payments::find($id);
        $payment->logo = public_path('img/invoice/default_logo.png');

        // dd($payment, Cashier::formatAmount(4200));

        // $pdf = Pdf::loadView('templates.invoice.invoice', compact("payment"));
        return Pdf::loadView('templates.invoice.invoice', compact("payment"))
            // ->setPaper('a6')
            ->setPaper(array(0,0,337, 432.5))
            ->setWarnings(false)
            ->stream('factura.pdf');
    }
}
