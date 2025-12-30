<?php

namespace App\Http\Requests\Payroll;

use App\Rules\RequiredIfBankak;
use App\Rules\UniqueInTables;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePayrollRequest extends FormRequest
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
            'year' => ['required', 'integer', 'min:2020', 'max:' . (now()->year)],
            'payment_date' => ['requiredIf:payment_status,Paid', 'nullable', 'date'],
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
            'required_if' => __('validation.required_if', ['value' => __('app.paid')])
        ];
    }
    
    public function attributes()
    {   
        return [
            'transaction_id' => __('app.process_number'),
            'year'  => __('app.year'),
            'payment_date' => __('app.payment_date'),
            'payment_status' => __('app.payment_state'),
        ];
    }
}
