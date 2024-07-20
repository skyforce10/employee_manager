<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Company;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyCreated;





class CompanyController extends Controller
{
    public function showCompManageForm()
    {
        $companies = Company::latest()->get();
        return view('companymanager', ['companies' => $companies]);
    }

    public function showcompanylist()
    {
        return view('companylist');
    }

    public function showcompanystatistic()
    {
        return view('companystatistic');
    }

    public function saveCompanyInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_company_name' => 'required|string',
            'input_company_website' => 'url',
        ], [
            'urlerror' => 'The company website must be a valid URL.',
        ]);


        $validator->after(function ($validator) use ($request) {
            $companyName = $request->input('input_company_name');
            if (Company::where('name', $companyName)->exists()) {
                $validator->errors()->add('company_exists', 'The company name already exists.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();
        $validatedData['input_company_address'] = $request->input('input_company_address');
        //=============================check company logo
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Resize image if big than 100 x 100
            $image = imagecreatefromstring(file_get_contents($file));
            $width = imagesx($image);
            $height = imagesy($image);

            if ($width > 100 || $height > 100) {
                $new_width = 100;
                $new_height = 100;

                $tmp_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($tmp_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                // Save i storage folder
                $path = 'companies_logo/' . $filename;
                Storage::disk('public')->put($path, file_get_contents($file));
                $image_path = storage_path('app/public/' . $path);

                if ($file->getClientOriginalExtension() == 'jpeg' || $file->getClientOriginalExtension() == 'jpg') {
                    imagejpeg($tmp_image, $image_path);
                } elseif ($file->getClientOriginalExtension() == 'png') {
                    imagepng($tmp_image, $image_path);
                } elseif ($file->getClientOriginalExtension() == 'gif') {
                    imagegif($tmp_image, $image_path);
                }

                imagedestroy($image);
                imagedestroy($tmp_image);

                $validatedData['company_logo'] = $path;
            } else {
                // Save the original image if resizing is not needed
                $path = 'companies_logo/' . $filename;
                Storage::disk('public')->put($path, file_get_contents($file));

                // Save the filename in the database
                $validatedData['company_logo'] = $path;
            }
        }
        //========================save after validation
        $company = new Company();
        $company->name = $validatedData['input_company_name'];
        $company->address = $validatedData['input_company_address'];
        $company->website = $validatedData['input_company_website'];
        $company->logo = $validatedData['company_logo'];
        $company->save();

        // Send email notification
        //Mail::to('mohamed.el.dakdouki@gmail.com')->send(new CompanyCreated($company));

        return redirect()->route('company')->with('success', 'Company created successfully!');
    }

    protected function checkIfCompanyExists($companyName)
    {
        return Company::where('name', $companyName)->exists();
    }

    public function getcopanies()
    {
        if (\request()->ajax()) {
            $companies = Company::latest()->get();
            return DataTables::of($companies)->make(true);
        }
        return [];
    }

    public function getcompemployeenb()
    {
        if (\request()->ajax()) {
            $results = Company::withCount('employees')
            ->get()
            ->map(function ($company) {
                return [
                    'name' => $company->name,
                    'address' => $company->address,
                    'nbemployee' => $company->employees_count,
                ];
            });
            return DataTables::of($results)->make(true);
        }
        return [];
    }
}
