<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalaryPaidRequest extends FormRequest
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
            'amount'            => 'required',
            'payment_date'      => 'required',
            'month'             => 'required',
            'signature_state'   => 'required',
            'statement'         => 'required',
            'teacher_id'        => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'amount'            => __('app.amount'),
            'payment_date'      => __('app.payment_date'),
            'month'             => __('app.the_month'),
            'signature_state'   => __('app.signature_state'),
            'statement'         => __('app.statement'),
            'teacher_id'        => __('app.teacher'),

        ];
    }
}
