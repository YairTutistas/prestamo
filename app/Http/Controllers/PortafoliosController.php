<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portafolios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortafoliosController extends Controller
{
    public function index(){
        $portafolios = Auth::user()->getPortafoliosByCompany();
        return view('portafolio.index', compact('portafolios'));
    }

    public function create(){
        $companys = Auth::user()->companies;
        $userRol = User::role('Cobrador')->get();
        return view('portafolio.create', compact('userRol', 'companys'));
    }
    public function save(Request $request){
        $company_id = $this->decrypt($request->company_id);
        $debt_collector = $this->decrypt($request->debt_collector);
        $portafolio = new Portafolios();
        $portafolio->name = $request->name;
        $portafolio->company_id = $company_id;
        $portafolio->debt_collector = $debt_collector;
        $portafolio->save();
        return redirect()->route('portafolios')->with('status', 'Successfully created portafolio');
    }

    public function show($id){
        $id = $this->decrypt($id);
        $portafolio = Portafolios::findOrFail($id);
        $companys = Auth::user()->companies;
        $users = User::all();
        return view('portafolio.show', compact('portafolio', 'users', 'companys'));
    }

    public function update($id, Request $request){
        $id = $this->decrypt($id);
        $company_id = $this->decrypt($request->company_id);
        $debt_collector = $this->decrypt($request->debt_collector);
        $portafolio = Portafolios::findOrFail($id);
        $portafolio->name = $request->name;
        $portafolio->company_id = $company_id;
        $portafolio->save();
        return redirect()->route('portafolios')->with('status', 'Successfully updated portafolio');
    }

    public function delete($id){
        $portafolio = Portafolios::findOrFail($id);
        $portafolio->delete();
        return 'Portafolio eliminado correctamente';
    }
}
