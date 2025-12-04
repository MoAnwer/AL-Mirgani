<?php

namespace App\Http\Requests\Employee;

use App\Rules\RequiredIfBankak;
use App\Rules\UniqueInTables;
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
                    return $query->where('month', $this->month)->where('year', $this->year);
                })
            ],
            'payment_method'    => ['sometimes'],
            'transaction_id'    => ['sometimes',  'max_digits:15', new RequiredIfBankak(),  new UniqueInTables(['earnings', 'expenses', 'registration_fees', 'installment_payments', 'employee_payrolls'], 'transaction_id')],
        ];
    }

    public function messages()
    {
        return [
            'unique' => __('app.duplicate_paid_payroll'),
            'payment_method' => __('app.payment_method'),
        ];
    }
    
    public function attributes()
    {
        return [
            'transaction_id' => __('app.process_number')
        ];
    }
}
