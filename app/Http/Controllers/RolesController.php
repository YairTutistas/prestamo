<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class RolesController extends Controller
{
    public function index() {
        $roles = Roles::all();
        return $roles;
    }

    public function create(Request $request){
        $roles = new Roles;
        $roles->name = $request->name;
        $roles->save();

        return 'Guardado correctamente';
    }
}
