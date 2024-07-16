<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    public function showCompManageForm(){
        return view('companymanager');
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
}
