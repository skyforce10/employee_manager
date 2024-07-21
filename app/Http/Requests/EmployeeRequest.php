<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Employee;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//===set true to authorise
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'input_first_name' => 'required|string|max:40',
            'input_last_name' => 'required|string|max:255',
            'input_email' => 'required|email',
            'emp_comp'=>'required',
            'phone_type.*' => 'nullable',
            'phone_numbers.*' => 'nullable|regex:/^\+?[1-9]\d{1,14}$/'
        ];
    }

    public function messages()
    {
        return [
            'input_first_name.required' => 'First Name is required.',
            'input_first_name.max' => 'First Name may not be greater than 40 characters.',
            'input_last_name.required' => 'Last Name is required.',
            'input_email.required' => 'Email is required.',
            'input_email.email' => 'Email must be a valid email address.',
            'phone_numbers.*.regex' => 'Each phone number must be in a valid international format.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $email = $this->input_email;
            $emp_code=$this->input_employee_code;
            if (Employee::where('email', $email)->exists()&&($emp_code=='')) {
                $validator->errors()->add('email_exists', 'The email already exists.');
            }
        });
    }
}
