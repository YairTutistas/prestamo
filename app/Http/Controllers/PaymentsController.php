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

    // public function save(Request $request){
    //     $loan_id = $this->decrypt($request->loan_id);
    //     $paymentType_id = $this->decrypt($request->paymentType_id);
    //     $valueLoan = Loans::select('total_pay')->where('id', $loan_id)->first();
    //     $valueQuota = Payment_plans::select('indivudual_value')->where('loan_id', $loan_id)->first();
    //     $count = Payments::where('loan_id', $request->loan_id)->sum('amount');
    //     $resultDiff = ($count + $request->amount) - $valueLoan->total_pay;
        
    //     if ($request->amount < $valueQuota->indivudual_value) {
            
    //     } else {
    //         $paymentPlan = Payment_plans::where('loan_id', $loan_id)->where('status', 1)->first();
    //         $paymentPlan->status = 2;
    //         $paymentPlan->save();
    //     }

    //     if ($count + $request->amount <= $valueLoan->total_pay) {
    //         $payment = new Payments();
    //         $payment->loan_id = $loan_id;
    //         $payment->payments_id = $paymentType_id;
    //         $payment->amount =  $request->amount;
    //         $payment->user_id =  Auth::user()->id;
    //         $payment->payment_date = $request->payment_date;
    //         $payment->save();
    //         return redirect()->route('payments')->with('status', 'Successfully created payment.');
    //     }else {
    //         return redirect()->route('createPayment')->with('status', 'The amount borrowed has been exceeded by. '. $resultDiff);
    //     }
    // }

    public function save(Request $request) {
        try {
            $loan_id = $this->decrypt($request->loan_id);
            $paymentType_id = $this->decrypt($request->paymentType_id);
        } catch (\Throwable $th) {
            return redirect()->route('createPayment')->with('status', 'Invalid loan or payment type ID.');
        }
    
        $valueLoan = Loans::select('total_pay')->where('id', $loan_id)->first();
        $valueQuota = Payment_plans::select('indivudual_value')->where('loan_id', $loan_id)->first();
    
        if (!$valueLoan || !$valueQuota) {
            return redirect()->route('createPayment')->with('status', 'Loan or payment plan not found.');
        }
    
        $count = Payments::where('loan_id', $loan_id)->sum('amount');
        $resultDiff = ($count + $request->amount) - $valueLoan->total_pay;
    
        // Obtener el último pago realizado para este préstamo
        $lastPayment = Payments::where('loan_id', $loan_id)
            ->orderBy('payment_date', 'desc')
            ->first();
    
        if ($lastPayment && $lastPayment->amount < $valueQuota->indivudual_value) {
            // Sumar el monto del nuevo pago al último pago parcial si existe
            $totalPaid = $lastPayment->amount + $request->amount;
        } else {
            // Si no hay último pago parcial o es suficiente para cubrir una cuota completa
            $totalPaid = $request->amount;
        }
    
        // Registrar el nuevo pago
        $payment = new Payments();
        $payment->loan_id = $loan_id;
        $payment->payments_id = $paymentType_id;
        $payment->amount = $request->amount;
        $payment->user_id = Auth::user()->id;
        $payment->payment_date = $request->payment_date;
        $payment->save();
    
        $this->updatePaymentPlanStatus($loan_id);
    
        if ($count + $request->amount <= $valueLoan->total_pay) {
            return redirect()->route('payments')->with('status', 'Successfully created payment.');
        } else {
            return redirect()->route('createPayment')->with('status', 'The amount borrowed has been exceeded by ' . $resultDiff);
        }
    }
    
    private function updatePaymentPlanStatus($loan_id) {
        // Obtener los planes de pago pendientes
        $paymentPlans = Payment_plans::where('loan_id', $loan_id)
            // ->where('status', 1)
            ->orderBy('id')
            ->get();
    
        // Calcular el total pagado para este préstamo
        // $totalPaid = Payments::where('loan_id', $loan_id)->get()->last();
        $totalPayment = Payments::where('loan_id', $loan_id)->get()->sum('amount');
    
        foreach ($paymentPlans as $paymentPlan) {
            // if ($totalPaid->amount >= $paymentPlan->indivudual_value) {
            if ($totalPayment >= $paymentPlan->indivudual_value) {
                $paymentPlan->status = 2; // Actualizar el estado del plan de pago
                $paymentPlan->save();
                $totalPayment -= $paymentPlan->indivudual_value;
            } else {
                break; // Si no se cumple el valor del plan de pago, salir del bucle
            }
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
        $payment = Payments::findOrFail($id);
        $loan_id = $payment->loan_id;
        // Obtener todos los Payment_plans asociados a este Loan
        $paymentPlans = Payment_plans::where('loan_id', $loan_id)
            ->orderBy('id', 'desc')
            ->get();


        // Revertir el estado de los Payment_plans afectados
        foreach ($paymentPlans as $paymentPlan) {
            if ($paymentPlan->status == 2) {
                // Actualizar el estado solo si el total pagado es mayor o igual al valor individual
                if ($payment->amount >= $paymentPlan->indivudual_value) {
                    $paymentPlan->status = 1;
                    $paymentPlan->save();
                    $payment->amount -= $paymentPlan->indivudual_value;
                }else if($payment->amount > 0){
                    $paymentPlan->status = 1;
                    $paymentPlan->save();
                    break;
                }
            }
        }

        // Eliminar el Payment
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
