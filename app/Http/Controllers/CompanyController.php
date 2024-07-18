<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Company;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    public function showCompManageForm(){
        $companies = Company::latest()->get();
        return view('companymanager',['companies'=>$companies]);
    }
    public function showcompanylist(){
        return view('companylist');
    }

    public function saveCompanyInfo(Request $request){
        $validatedData = $request->validate([
            'input_company_name' => 'required|string|min:255',
            'input_company_address' => 'required|string',
            'input_company_website' => 'required|url',
        ]);

        throw ValidationException::withMessages([
            'compname' => [trans('auth.failed')],
        ]);
    }

    public function getcopanies()
    {
        if(\request()->ajax()){
            $companies = Company::latest()->get();
            return DataTables::of($companies)->make(true);
        }
        return [];
    }
}
