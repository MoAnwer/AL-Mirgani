<?php

namespace App\Http\Requests\Payment;

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
            'paid_amount'       => 'required',
            'payment_method'    => 'required',
            'payment_date'      => 'required|date',
            'notes'             => 'sometimes',
            'student_id'        => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'paid_amount'       => __('app.paid_amount'),
            'payment_method'    => __('app.payment_method'),
            'payment_date'      => __('app.payment_date'),
            'notes'             => __('app.notes')
        ];
    }
}
