<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use Carbon\Carbon;
use App\Models\Clients;
use App\Models\Payments;
use App\Models\Portafolios;
use Illuminate\Http\Request;
use App\Models\Payment_plans;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PortafolioClientController;

class LoansController extends Controller
{
    public function index() {
        // $loans = Auth::user()->getPaymentPlanWithDaysInArrears();
        // $loans = Auth::user()->getLoansByCompany()->where('status', 1);
        $paymentPlans = Auth::user()->getPaymentPlanWithDaysInArrears();
        // dd($paymentPlans);
        return view('loan.index', compact('paymentPlans'));
    }

    public function create() {

        if (Auth::user()->hasAnyRole('Admin')) {
            $user = Auth::user();
            $portafolios = $user->getPortafoliosByCompany();
            if (!count($portafolios)) {
                return redirect()->route('loans')->with('status', 'No portafolios was found');
            }
            $clients = $user->getClientByCompany();
            $companys = $user->companies;
            return view('loan.create', compact('portafolios', 'clients', 'companys'));
            
        } elseif (Auth::user()->hasAnyRole('Cobrador')){
            $user = Auth::user();
            $portafolios = $user->portafoliosByDebtCollector;
            $companys = $user->getCompaniesAsDebtCollector();
            $loans = $user->getLoansByPortafolio()->where('status', 1);
            return view('cobrador.loan.create', compact('portafolios', 'loans','companys'));
        }

    }

    public function save(Request $request) {
        $data = $request->all();
        $dataClient = $data['loan']['client_id'];
        $loan_id = 0;
        if (strpos($dataClient, "-") !== false) {
            $loan_id = explode("-", $dataClient);
            if (isset($loan_id[1])) {
                $loan_id = $loan_id[1];
            }
        }
        // dd($loan_id);
        $company_id = $this->decrypt($data['loan']['company_id']);
        $client_id = $this->decrypt($data['loan']['client_id']);
        // Sacar porcentaje
        $percentage = (preg_replace('([^A-Za-z0-9])', '', $data['loan']['amount']) * $data['loan']['interest_rate']) / 100;
        // Generar total a pagar
        $total_pay = preg_replace('([^A-Za-z0-9])', '', $data['loan']['amount']) + $percentage;

        $loan = new Loans();
        $loan->portafolio_id = $data['loan']['portafolio_id'];
        $loan->company_id = $company_id;
        $loan->client_id = $client_id;
        $loan->amount = preg_replace('([^A-Za-z0-9])', '', $data['loan']['amount']);
        $loan->interest_rate = $data['loan']['interest_rate'];
        $loan->deadlines = $data['loan']['deadlines'];
        $loan->payment_method = $data['loan']['payment_method'];
        $loan->quota_value = preg_replace('([^A-Za-z0-9])', '', $data['loan']['quota_value']);
        $loan->start_date = $data['loan']['start_date'];
        $loan->end_date = $data['loan']['end_date'];
        if (Auth::user()->hasRole('Cobrador')) {
            $loan->status = 3;
            $loan->flag = $loan_id;
        }
        $loan->total_pay = $total_pay;
        $loan->save();
        $loan->paymentPlans()->createMany($data["payment_plan"]);

        $portafolio_id = $loan->portafolio_id;
        $client_id = $loan->client_id;
        $portClient = new PortafolioClientController();
        $portClient->create($portafolio_id, $client_id);
        return redirect()->route('loans')->with('status', 'Successfully created loan');
    }

    public function show($id) {
        $companys = Auth::user()->companies;
        $id = $this->decrypt($id);
        $loan = Loans::find($id);
        $portafolios = Portafolios::all();
        return view('loan.edit', compact('loan', 'portafolios','companys'));
    }

    public function update($id, Request $request) {
        // dd($request);
        $id = $this->decrypt($id);
        $portafolio_id = $this->decrypt($request->portafolio_id);
        $client_id = $this->decrypt($request->client_id);
        $company_id = $this->decrypt($request->company_id);
        $loan = Loans::find($id);
        $loan->portafolio_id = $portafolio_id;
        $loan->company_id = $company_id;
        $loan->client_id = $client_id;
        $loan->amount = $request->amount;
        $loan->interest_rate = $request->interest_rate;
        $loan->deadlines = $request->deadlines;
        $loan->payment_method = $request->payment_method;
        $loan->quota_value = $request->quota_value;
        $loan->start_date = $request->start_date;
        $loan->end_date = $request->end_date;
        $loan->save();
        return redirect()->route('loans')->with('status', 'Successfully updated loan');
    }

    public function delete($id) {
        $id = $this->decrypt($id);
        $loan = Loans::find($id);
        $loan->delete();
        return redirect()->route('loans')->with('status', 'Successfully delete loan');
    }

    public function loanPending(){
        $loans = Auth::user()->getLoansByPortafolio()->where('status', 3);
        return view('loan.pending', compact('loans'));
    }

    public function Approve($id){
        $id = $this->decrypt($id);
        $loan = Loans::find($id);
        $otherLoan = Loans::find($loan->flag);
        // Realizamos la consulta del prestamo referenciado para traer el valor total
        $totalPayOtherLoan = $otherLoan->total_pay;
        // Recopilamos los pago que tiene el prestamo referenciado
        $totalPaid = $otherLoan->payments()->sum('amount');
        $totalValue = $totalPayOtherLoan - $totalPaid;
        if ($totalValue != 0) {
            // Establece un mensaje de sesión para SweetAlert
            session()->flash('alerta', [
                'titulo' => 'Este prestamo aun tiene saldos pendientes, ¿Deseas renovarlo?',
                'texto' => 'Ten en cuenta que si das, Sí, se completaran los saldos del prestamo anterior e iniciara uno nuevo.',
                'tipo' => 'question', // Puedes usar 'success', 'error', 'warning', 'info'
                'confirmButtonText' => 'Sí',
                'cancelButtonText' => 'No'
            ]);
            return back()->with('loan_id', $loan->id);
        }
        // Cambia el estado del prestamo nuevo a 1
        $loan->status = 1;
        $loan->save();
        // Buscamos el prestamos referenciado por la columna flag y le cambiamos el estado a 2
        $otherLoan = Loans::find($loan->flag);
        $otherLoan->status = 2;
        $otherLoan->save();

        $paymentPlans = Payment_plans::where('loan_id', $otherLoan->id)->get();
        foreach ($paymentPlans as $paymentPlan) {
            $paymentPlan->status = 2;
            $paymentPlan->save();
        }
    
        return redirect()->route('pendingLoan')->with('status', 'Successfully approved loan');
        
    }


    public function confirm($id)
    {
        $loan = Loans::find($id);
        $companie = Auth::user()->companies->where('id', $loan->company_id)->first();
        // Condición que comprueba si la compañia viene vacia
        if (!$companie) {
            return redirect()->route('pendingLoan')->with('status', 'Nel perro');
        }

        $message = "Successfully approved loan";
        // Condición de validación si la campia del usuario es la misma a la que pertenece el prestamo
        if ($loan->company_id == $companie->id) {
            DB::beginTransaction();
            try {
                // Cambia el estado del prestamo nuevo a 1
                $loan->status = 1;
                $loan->save();
                // Buscamos el prestamos referenciado por la columna flag y le cambiamos el estado a 2
                $otherLoan = Loans::find($loan->flag);
                $otherLoan->status = 2;
                $otherLoan->save();
    
                Payment_plans::where('loan_id', $otherLoan->id)->update(['estatus' => 2]);
                // $paymentPlans = Payment_plans::where('loan_id', $otherLoan->id)->update(['estatus' => 2]);
                // foreach ($paymentPlans as $paymentPlan) {
                //     $paymentPlan->status = 2;
                //     $paymentPlan->save();
                // }
                // Realizamos la consulta del prestamo referenciado para traer el valor total
                $totalPayOtherLoan =$otherLoan->total_pay;
                // Recopilamos los pago que tiene el prestamo referenciado
                $totalPaid = $otherLoan->payments()->sum('amount');
                $totalValue = $totalPayOtherLoan - $totalPaid;
                // Creamos una nueva instancia para registrar el valor restante que le hace al prestamo referenciado
                $payment = new Payments();
                $payment->loan_id = $otherLoan->id;
                $payment->payments_id = 1;
                $payment->user_id = Auth::user()->id;
                $payment->amount = $totalValue;
                $payment->payment_date = date('Y-m-d');
                $payment->save();

                DB::commit();
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                $message = "It was not possible to approve the loan";
            }
    
            return redirect()->route('pendingLoan')->with('status', $message);
        }

        return redirect()->route('pendingLoan')->with('status', 'Nel perro');
        
    }

    public function cancelConfirm($id)
    {
        $loan = Loans::find($id);
        $companie = Auth::user()->companies->where('id', $loan->company_id)->first();

        if (!$companie) {
            return redirect()->route('pendingLoan')->with('status', 'Nel perro');
        }

        if ($loan->company_id == $companie->id) {
            $loan->status = 1;
            $loan->save();

            return redirect()->route('pendingLoan')->with('status', 'Successfully approved loan');
        }
        return redirect()->route('pendingLoan')->with('status', 'Nel perro');
        

    }

    public function loanPendientCounter()
    {
        $counter = Auth::user()->getLoansByPortafolio()->where('status', 3)->count();

        return $counter;
    }
}
