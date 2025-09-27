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
            'full_name'         => ['required', 'string'],
            'address'           => ['nullable', 'string'],
            'stage'             => ['required'],
            'school'            => ['required'],
            'class'             => ['required'],
            'total_fee'         => ['required', 'integer'],
            'parent_name'       => ['required', 'string'],
            'phone_one'         => ['required', 'string'],
            'phone_two'         => ['nullable', 'string'],
            'amount'            => ['required', 'integer'],
            'paid_amount'       => ['nullable', 'integer'],
            'payment_method'    => ['nullable', 'string'],
            'transaction_id'    => ['nullable', 'string'],
            'payment_date'      => ['nullable']
        ];
    }
    
    public function attributes(): array
    {
        return [
            'full_name'     => __('app.student_full_name'),
            'stage'         => __('app.stage'),
            'class'         => __('app.class'),
            'total_fee'     => __('app.total_fee'),
            'amount'        => __('app.registration_fee'),
            'parent_name'   => __('app.parent_full_name'),
            'phone_one'     => __('app.phone_one')
        ];
    }
}
