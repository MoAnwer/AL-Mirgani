<?php

namespace App\Http\Requests\Earning;

use App\Rules\RequiredIfBankak;
use App\Rules\UniqueInTables;
use Illuminate\Foundation\Http\FormRequest;

class CreateEarningRequest extends FormRequest
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
            'amount'    => ['required', 'max_digits:15'],
            'statement' => ['required', 'string'],
            'date'      => ['required'],
            'payment_method'    => ['sometimes'],
            'transaction_id'    => ['sometimes',  new RequiredIfBankak(),  new UniqueInTables(['earnings', 'expenses', 'registration_fees', 'installment_payments', 'employee_payrolls'], 'transaction_id'),  'max_digits:15'],
            'school_id' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'amount'        => __('app.amount'),
            'statement'     => __('app.statement'),
            'date'          => __('app.date'),
            'school_id'     => __('app.school'),
            'payment_method' => __('app.payment_method'),
            'transaction_id' => __('app.process_number')
        ];
    }
}
