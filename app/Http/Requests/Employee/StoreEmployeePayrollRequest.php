<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeePayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2020', 'max:' . (now()->year + 1)],
            'payment_date' => ['nullable', 'date'],
            'payment_status' => ['required', Rule::in(['Pending', 'Paid', 'Failed'])],
            'employee_id' => [
                Rule::unique('employee_payrolls', 'employee_id')->where(function ($query) {
                    return $query->where('month', $this->month)
                                 ->where('year', $this->year);
                })
            ],
            
            'total_deductions' => ['required', 'numeric', 'min:0'],
            'total_fixed_allowances' => ['required', 'numeric', 'min:0'],
            'total_variable_additions' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'unique' => __('app.duplicate_paid_payroll'),
        ];
    }
}