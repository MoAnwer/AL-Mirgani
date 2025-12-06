<?php

namespace App\Http\Requests\Student;

use App\Rules\RequiredIfBankak;
use App\Rules\UniqueInTables;
use Illuminate\Foundation\Http\FormRequest;

class RegisterStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name'         => ['required', 'string', 'max:255'],
            'address'           => ['nullable', 'string', 'max:255'],
            'stage'             => ['required'],
            'school'            => ['required'],
            'class'             => ['required'],
            'total_fee'         => ['required', 'max_digits:15'],
            'discount'          => ['nullable', 'max_digits:3'],
            'parent_name'       => ['required', 'string', 'max:255'],
            'phone_one'         => [
                'required',
                'string',
                'max_digits:15',
                'unique:fathers,phone_one',
                'unique:fathers,phone_two',
                'unique:employees,phone_number',
            ],
            'phone_two'         => [
                'nullable',
                'string',
                'max_digits:15',
                'unique:fathers,phone_one',
                'unique:fathers,phone_two',
                'unique:employees,phone_number'
            ],
            'registration_fee'  => ['required', 'max_digits:15'],
            'paid_amount'       => ['required', 'max_digits:15'],
            'payment_method'    => ['nullable', 'string'],
            'transaction_id'    => ['sometimes', 'max_digits:15', new RequiredIfBankak(), new UniqueInTables(['earnings', 'expenses', 'registration_fees', 'installment_payments', 'employee_payrolls'], 'transaction_id')],
            'payment_date'      => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'address'           => __('app.address'),
            'full_name'         => __('app.student_full_name'),
            'stage'             => __('app.stage'),
            'class'             => __('app.class'),
            'paid_amount'       => __('app.paid_amount'),
            'school'            => __('app.school'),
            'total_fee'         => __('app.total_fee'),
            'registration_fee'  => __('app.registration_fee'),
            'parent_name'       => __('app.parent_full_name'),
            'phone_one'         => __('app.phone_one'),
            'phone_two'         => __('app.phone_two')
        ];
    }
}
