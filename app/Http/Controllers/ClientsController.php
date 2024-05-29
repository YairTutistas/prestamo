<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loans;
use App\Models\Clients;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index(){
        if (Auth::user()->hasAnyRole('Admin', 'Master')) {
            // return view('client.index', compact('clients'));
            return redirect()->route('admin');
            
        } elseif (Auth::user()->hasAnyRole('Cobrador')){
            // return view('cobrador.index', compact('clients'));
            return redirect()->route('cobrador');
        }
    }

    public function indexCobrador(){
        // $loans = Loans::join('portafolios', 'loans.portafolio_id', 'portafolios.id')
        // ->where('portafolios.user_id', Auth::user()->id)
        // ->select('loans.*')
        // ->get();

        // Traer toda los prestamos con relaciones eloquent
        $loans = Auth::user()->getLoansByPortafolio->where('status', 1);
        return view('cobrador.index', compact('loans'));
    }
    public function indexAdmin(){
        $user = Auth::user();
        $clients = $user->clients;
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
        return redirect()->route('admin')->with('status', 'Successfully created client');
    }

    public function show($id){
        $id = $this->decrypt($id);
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
        $id = $this->decrypt($id);
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
        return redirect()->route('admin')->with('status', 'Successfully updated client');
    }

    public function delete($id) {
        $id = $this->decrypt($id);
        $data = Clients::find($id);
        $data->delete();
        return redirect()->route('admin')->with('status', 'Successfully deleted client');
    }

    public function loans($id){
        $id = $this->decrypt($id);
        $loansClient = Loans::where('client_id', $id)->get();
        return view('client.loans', compact('loansClient'));
    }
}
