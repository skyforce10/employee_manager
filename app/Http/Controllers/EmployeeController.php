<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EmployeeRequest;

class EmployeeCOntroller extends Controller
{
    public function showEmployeeManagerForm()
    {
        $companies = Company::latest()->get();
        return view('employeemanager', ['companies' => $companies]);
    }
    public function showEmpEditForm($id)
    {
        $employee = Employee::where('id', $id)->first();
        $phone_numbers_array = json_decode($employee->phone_numbers, true);
        $phone_numbers=[];
        if(sizeof($phone_numbers_array)){
        $phone_numbers = [];
        foreach ($phone_numbers_array as $entry) {
            foreach ($entry as $key => $value) {
                $phone_numbers[$key] = $value;
            }
        }
    }
        $companies = Company::latest()->get();
        return view('employeemanager', ['employee' => $employee, 'companies' => $companies, 'phone_numbers' => $phone_numbers]);
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

    public function saveemployee(EmployeeRequest $request)
    {


        $employeeid = $request->input('input_employee_code');
        $validatedData = $request->validated();

        $validatedData['profile_picture'] = '';
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();


            $path = 'profile_pictures/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($file));
            $validatedData['profile_picture'] = $path;
        }

        //========================save after validation
        if ($employeeid != '') {
            $employee = employee::where('id', $employeeid)->first();
        } else {
            $employee = new employee();
        }

        $employee->first_name = $validatedData['input_first_name'];
        $employee->last_name = $validatedData['input_last_name'];
        $employee->email = $validatedData['input_email'];
        if (isset($validatedData['input_bd'])) {
            $employee->date_of_birth = $validatedData['input_bd'];
        }
        $employee->married = $validatedData['married'] ?? 0;
        $employee->number_of_kids = $validatedData['married'] ?? 0;
        $employee->company_id = $validatedData['emp_comp'];
        if (isset($file)) {
          $employee->profile_picture = $validatedData['profile_picture'];
        }

        $phone_type_array = $validatedData['phone_type'];
        $phone_numbers_array = $validatedData['phone_numbers'];
        $combined_array = [];
        foreach ($phone_type_array as $index => $type) {
            if ($phone_numbers_array[$index] != "") {
                $combined_array[] = [
                    $type => $phone_numbers_array[$index]
                ];
            }
        }
        $employee->phone_numbers = $combined_array;

        $employee->save();

        return redirect()->route('employeemanager')->with('success', 'Employee created successfully!');
    }

    public function deleteemployee($emp_id)
    {
        try {
            $employee = Employee::findOrFail($emp_id);
            $employee->delete();

            return response()->json(['message' => 'Employee deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while trying to delete the employee.'], 500);
        }
    }
}
