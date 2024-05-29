<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portafolios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortafoliosController extends Controller
{
    public function index(){
        $portafolios = Auth::user()->portafolios;
        return view('portafolio.index', compact('portafolios'));
    }

    public function create(){
        $userRol = User::role('Cobrador')->get();
        return view('portafolio.create', compact('userRol'));
    }
    public function save(Request $request){
        // $data = $request->all();
        $portafolio = new Portafolios();
        $portafolio->name = $request->name;
        $portafolio->user_id = Auth::user()->id;
        $portafolio->debt_collector = $request->debt_collector;
        $portafolio->save();
        return redirect()->route('portafolios')->with('status', 'Successfully created portafolio');
    }

    public function show($id){
        $id = $this->decrypt($id);
        $portafolio = Portafolios::findOrFail($id);
        $users = User::all();
        return view('portafolio.show', compact('portafolio', 'users'));
    }

    public function update($id, Request $request){
        $id = $this->decrypt($id);
        $portafolio = Portafolios::findOrFail($id);
        $portafolio->name = $request->name;
        $portafolio->user_id = $request->user_id;
        $portafolio->save();
        return redirect()->route('portafolios')->with('status', 'Successfully updated portafolio');
    }

    public function delete($id){
        $portafolio = Portafolios::findOrFail($id);
        $portafolio->delete();
        return 'Portafolio eliminado correctamente';
    }
}
