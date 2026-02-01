<?php

namespace App\Http\Requests\Payroll;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StorePayrollDetail extends FormRequest
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
            'item_id' => [
                'required',
                'exists:payroll_items,id',

                /** I REMOVE THIS RULE */

                // Ensure this item hasn't already been added to this specific payroll
                //Rule::unique('payroll_details')->where(function ($query) {
                  //  return $query->where('payroll_id', $this->payroll->id);
                //}),
            ],
            'date'   => 'required',
            'amount' => 'required|numeric|min:0.01|max_digits:15',
            'notes' => 'nullable|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'item_id' => __('app.item')
        ];
    }
}
