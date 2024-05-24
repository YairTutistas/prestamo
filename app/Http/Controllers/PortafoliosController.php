<?php

namespace App\Http\Controllers;

use App\Models\Portafolios;
use Illuminate\Http\Request;

class PortafoliosController extends Controller
{
    public function index(){
        $portafolios = Portafolios::all();
        return view('portafolio.index', compact('portafolios'));
    }

    public function create(){
        return view('portafolio.create');
    }
    public function save(Request $request){
        // $data = $request->all();
        $portafolio = new Portafolios();
        $portafolio->name = $request->name;
        $portafolio->user_id = 1;
        $portafolio->save();
        return redirect()->route('portafolios')->with('status', 'Successfully created portafolio');
    }

    public function show($id){
        $portafolio = Portafolios::findOrFail($id);
        return $portafolio;
    }

    public function update($id, Request $request){
        $portafolio = Portafolios::findOrFail($id);
        $portafolio->name = $request->name;
        $portafolio->user_id = $request->user_id;
        $portafolio->save();
        return 'Portafolio actualizado correctamente';
    }

    public function delete($id){
        $portafolio = Portafolios::findOrFail($id);
        $portafolio->delete();
        return 'Portafolio eliminado correctamente';
    }
}
