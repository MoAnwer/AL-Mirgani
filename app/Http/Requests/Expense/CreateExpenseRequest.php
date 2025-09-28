<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class CreateExpenseRequest extends FormRequest
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
            'statement'     => ['required', 'string'],
            'amount'        => ['required', 'integer'],
            'category_id'   => ['required'],
            'school_id'     => ['required'],
            'date'          => ['required'],
            'user_id'       => ['nullable']
        ];
    }

    public function attributes()
    {        
        return [
            'statement'     => __('app.statement'),
            'amount'        => __('app.amount'),
            'category_id'   => __('app.category'),
            'school_id'     => __('app.school'),
            'date'          => __('app.date'),
        ];
    }

    public function messages()
    {
        return [
            'category_id'   =>  __('validation.in', ['attribute' => __('app.category') .' '. __('app.expense')])
        ];
    }
}
