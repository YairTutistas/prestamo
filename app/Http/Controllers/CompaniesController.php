<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompaniesController extends Controller
{
    public function index() 
    {
        $companies = Auth::user()->companies;
        return view('company.index', compact('companies'));
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $company = new Companies();
        $company->name = $request->name;
        $company->user_id = Auth::user()->id;
        $company->save();
        return redirect()->route('company')->with('status', 'Successfully created company');
    }
}
