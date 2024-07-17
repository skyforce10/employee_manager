<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeCOntroller extends Controller
{
    public function showEmployeeManagerForm(){
        return view('employeemanager');
    }
}
