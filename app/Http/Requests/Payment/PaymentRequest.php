<?php

namespace App\Http\Requests\Payment;

use App\Rules\RequiredIfBankak;
use App\Rules\UniqueInTables;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'paid_amount'       => 'required|max_digits:15',
            'payment_method'    => 'required',
            'payment_date'      => 'required|date',
            'statement'         => 'required|max:255',
            'student_id'        => 'required',
            'transaction_id'    => ['sometimes', 'max_digits:15',  new RequiredIfBankak(), new UniqueInTables(['earnings', 'expenses', 'registration_fees', 'installment_payments', 'employee_payrolls'], 'transaction_id')],
        ];
    }

    public function attributes(): array
    {
        return [
            'paid_amount'       => __('app.paid_amount'),
            'payment_method'    => __('app.payment_method'),
            'payment_date'      => __('app.payment_date'),
            'statement'         => __('app.notes'),
            'transaction_id'    => __('app.process_number')
        ];
    }
}
