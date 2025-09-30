<?php

namespace App\Http\Requests\Earning;

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
            'amount'    => ['required'],
            'statement' => ['required', 'string'],
            'date'      => ['required'],
            'school_id' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'amount'        => __('app.amount'),
            'statement'     => __('app.statement'),
            'date'          => __('app.date'),
            'school_id'     => __('app.school')
        ];
    }
}
