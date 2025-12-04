<?php

namespace App\Http\Requests\Installment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstallmentRequest extends FormRequest
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
            'amount'    => 'required|max_digits:15',
            'number'    => 'required|string|max:255',
            'due_date'  => 'required|date'
        ];
    }


    public function attributes()
    {
        return [
            'number'    => __('app.number', ['attribute' => __('app.the_installment')]),
            'amount'    => __('app.amount'),
            'due_date'  => __('app.due_date')
        ];
    }
}
