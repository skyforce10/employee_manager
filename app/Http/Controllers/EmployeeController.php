<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use Yajra\DataTables\DataTables;

class EmployeeCOntroller extends Controller
{
    public function showEmployeeManagerForm()
    {
        $companies = Company::latest()->get();
        return view('employeemanager', ['companies' => $companies]);
    }
    public function showEmployeeList()
    {
        return view('employeelist');
    }

    public function getemployees()
    {
        if (\request()->ajax()) {
            $employees = Employee::latest()
                ->join('companies', 'employees.company_id', '=', 'companies.id')
                ->select('employees.*', 'companies.name as company_name')
                ->get();
            return DataTables::of($employees)->make(true);
        }
        return [];
    }
}
