<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Clients;
use App\Models\Portafolios;
use Illuminate\Http\Request;
use App\Http\Controllers\PortafolioClientController;

class LoansController extends Controller
{
    public function index() {
        $loans = Loans::all();
        return view('loan.index', compact('loans'));
    }

    public function create() {
        $portafolios = Portafolios::all();
        $clients = Clients::all();
        return view('loan.create', compact('portafolios', 'clients'));
    }

    public function save(Request $request) {
        // $data = $request->all();
        // Sacar porcentaje
        $percentage = ($request->amount * $request->interest_rate) / 100;
        // Generar total a pagar
        $total_pay = $request->amount + $percentage;

        $loan = new Loans();
        $loan->portafolio_id = $request->portafolio_id;
        $loan->user_id = 1;
        $loan->client_id = $request->client_id;
        $loan->amount = $request->amount;
        $loan->interest_rate = $request->interest_rate;
        $loan->deadlines = $request->deadlines;
        $loan->payment_method = $request->payment_method;
        $loan->quota_value = $request->quota_value;
        $loan->start_date = $request->start_date;
        $loan->end_date = $request->end_date;
        $loan->total_pay = $total_pay;
        $loan->save();

        $portafolio_id = $loan->portafolio_id;
        $client_id = $loan->client_id;
        $portClient = new PortafolioClientController();
        $portClient->create($portafolio_id, $client_id);
        return redirect()->route('loans')->with('status', 'Successfully created loan');
    }

    public function show($id) {
        $loan = Loans::find($id);
        $portafolios = Portafolios::all();
        return view('loan.edit', compact('loan', 'portafolios'));
    }

    public function update($id, Request $request) {
        $loan = Loans::find($id);
        $loan->portafolio_id = $request->portafolio_id;
        $loan->user_id = 1;
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
        $loan = Loans::find($id);
        $loan->delete();
        return redirect()->route('loans')->with('status', 'Successfully delete loan');
    }
}
