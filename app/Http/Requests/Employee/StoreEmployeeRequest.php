<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name'     => 'required',
            'phone_number'  => 'required|unique:employees,phone_number',
            'hire_date'     => 'sometimes',
            'salary'        => 'required',
            'department'    => 'required'
        ];
    }


    public function attributes(): array
    {
        return [
            'full_name'     => __('app.employee_name'),
            'salary'        => __('app.salary'),
            'phone_number'  => __('app.phone_one'),
            'department'    => __('app.department')
        ];
    }
}
