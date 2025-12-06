<?php

namespace App\Http\Requests\Installment;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstallmentRequest extends FormRequest
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
            'number'        =>   ['required', 'max:255'],
            'amount'        =>   ['required', 'max_digits:15'],
            'due_date'      =>   ['required'],
            'student_id'    =>   ['required']
        ];
    }

    public function attributes(): array
    {
        return [
            'number'    => __('app.number', ['attribute' => __('app.the_installment')]),
            'amount'    => __('app.amount'),
            'due_date'  => __('app.due_date'),
        ];
    }
}
