<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Clients;
use App\Models\Portafolios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PortafolioClientController;

class LoansController extends Controller
{
    public function index() {
        $loans = Auth::user()->loans;
        return view('loan.index', compact('loans'));
    }

    public function create() {

        if (Auth::user()->hasAnyRole('Admin')) {
            $user = Auth::user();
            $portafolios = $user->portafolios;
            $clients = $user->clients;
            return view('loan.create', compact('portafolios', 'clients'));
            
        } elseif (Auth::user()->hasAnyRole('Cobrador')){
            $user = Auth::user();
            $portafolios = $user->portafoliosByDebtCollector;
            $clients = $user->getClientsByPortafolio();
            return view('loan.create', compact('portafolios', 'clients'));
        }

    }

    public function save(Request $request) {
        $data = $request->all();
        // Sacar porcentaje
        $percentage = (preg_replace('([^A-Za-z0-9])', '', $data['loan']['amount']) * $data['loan']['interest_rate']) / 100;
        // Generar total a pagar
        $total_pay = preg_replace('([^A-Za-z0-9])', '', $data['loan']['amount']) + $percentage;

        $loan = new Loans();
        $loan->portafolio_id = $data['loan']['portafolio_id'];
        $loan->user_id = Auth::user()->id;
        $loan->client_id = $data['loan']['client_id'];
        $loan->amount = preg_replace('([^A-Za-z0-9])', '', $data['loan']['amount']);
        $loan->interest_rate = $data['loan']['interest_rate'];
        $loan->deadlines = $data['loan']['deadlines'];
        $loan->payment_method = $data['loan']['payment_method'];
        $loan->quota_value = preg_replace('([^A-Za-z0-9])', '', $data['loan']['quota_value']);
        $loan->start_date = $data['loan']['start_date'];
        $loan->end_date = $data['loan']['end_date'];
        if (Auth::user()->hasRole('Cobrador')) {
            $loan->status = 3;
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
        $id = $this->decrypt($id);
        $loan = Loans::find($id);
        $portafolios = Portafolios::all();
        return view('loan.edit', compact('loan', 'portafolios'));
    }

    public function update($id, Request $request) {
        $id = $this->decrypt($id);
        $loan = Loans::find($id);
        $loan->portafolio_id = $request->portafolio_id;
        $loan->user_id = Auth::user()->id;
        $loan->client_id = $request->client_id;
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
        $loans = Auth::user()->getLoansByPortafolio->where('status', 3);
        return view('loan.pending', compact('loans'));
    }

    public function Approve($id){
        $id = $this->decrypt($id);
        $loan = Loans::find($id);
        $loan->status = 1;
        $loan->user_id = Auth::user()->id;
        $loan->save();
        return redirect()->route('pendingLoan')->with('status', 'Successfully approved loan');
        
    }

    public function loanPendientCounter()
    {
        $counter = Auth::user()->getLoansByPortafolio->where('status', 3)->count();

        return $counter;
    }
}
