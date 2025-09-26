<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStudentRequest extends FormRequest
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
            'full_name'   => ['required', 'string'],
            'address'     => ['nullable', 'string'],
            'stage'       => ['required'],
            'school'      => ['required'],
            'class'       => ['required'],
            'total_fee'   => ['required', 'integer'],
            'parent_name' => ['required', 'string'],
            'phone_one'   => ['required', 'string'],
            'phone_two'   => ['nullable', 'string'],
            'amount'      => ['required', 'integer'],
            'paid_amount' => ['nullable', 'integer'],
            'payment_method'   => ['required', 'string'],
            'transaction_id'   => ['nullable', 'string'],
            'payment_date' => ['nullable']
        ];
    }
}
