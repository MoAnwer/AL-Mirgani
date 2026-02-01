<?php

namespace App\Http\Requests\Student;

use App\Rules\RequiredIfBankak;
use App\Rules\UniqueInTables;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationFeeRequest extends FormRequest
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
            'amount'            => ['required', 'max_digits:15'],
            'paid_amount'       => ['required', 'max_digits:15'],
            'payment_method'    => ['required', 'string'],
            'transaction_id'    => ['sometimes', 'max_digits:15', new RequiredIfBankak(), new UniqueInTables(['earnings', 'expenses', 'registration_fees', 'installment_payments', 'employee_payrolls'], 'transaction_id')],
            'payment_date'      => ['required', 'date'],
        ];
    }

    public function attributes()
    {
        return [
            'amount'    => __('app.amount'),
            'paid_amount' => __('app.paid_amount'),
            'payment_method'    => __('app.payment_method'),
            'transaction_id'    => __('app.transaction_id'),
            'payment_date'  => __('app.payment_date')
        ];
    }
}
