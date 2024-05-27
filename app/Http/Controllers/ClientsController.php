<?php

namespace App\Http\Controllers;

use App\Models\Loans;
use App\Models\Clients;
use App\Models\Payments;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index(){
        $clients = Clients::all();
        return view('client.index', compact('clients'));
    }

    public  function create(){
        return view('client.create');
    }
    public  function save(Request $request){
        // $data = $request->all();
        $client = new Clients();
        $client->user_id = 1;
        $client->name = $request->name;
        $client->type_document = $request->type_document;
        $client->document = $request->document;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->addresses = $request->addresses;
        $client->department = $request->department;
        $client->city = $request->city;
        $client->neighborhood = $request->neighborhood;
        $client->save();
        return redirect()->route('clients')->with('status', 'Successfully created client');
    }

    public function show($id){
        $client = Clients::findOrFail($id);
        $payments = Loans::join('clients', 'loans.client_id', '=', 'clients.id')
        ->join('payments', 'loans.id', '=', 'payments.loan_id')
        ->where('clients.id', $client->id)
        ->select('loans.*', 'payments.amount', 'payments.payment_date', 'payments.id as payment_id', 'loans.total_pay')
        ->orderBy('loans.id')
        ->get();

        return view('client.view', compact('client', 'payments'));
    }

    public function update($id, Request $request){
        $client = Clients::find($id);
        $client->user_id = 1;
        $client->name = $request->name;
        $client->type_document = $request->type_document;
        $client->document = $request->document;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->addresses = $request->addresses;
        $client->department = $request->department;
        $client->city = $request->city;
        $client->neighborhood = $request->neighborhood;
        $client->save();
        return redirect()->route('clients')->with('status', 'Successfully updated client');
    }

    public function delete($id) {
        $data = Clients::find($id);
        $data->delete();
        return redirect()->route('clients')->with('status', 'Successfully deleted client');
    }

    public function loans(Clients $client){
        $loansClient = Loans::where('client_id', $client->id)->get();
        return view('client.loans', compact('loansClient'));
    }
}
