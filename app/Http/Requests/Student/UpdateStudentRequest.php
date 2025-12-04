<?php

namespace App\Http\Requests\Student;

use App\Rules\UniqueInTables;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            'stage'     => ['required'],
            'address'   => ['required', 'max:255'],
            'total_fee' => ['required', 'max_digits:15'],
            'class_id'  => ['required'],
            'school_id' => ['required'],
            'phone_one'         => [
                'nullable',
                'max_digits:15',
                'unique:fathers,phone_one,' . $this->student->father->id,
                'unique:fathers,phone_two,' . $this->student->father->id ,
                'unique:employees,phone_number',
            ],
            'phone_two'         => [
                'nullable',
                'max_digits:15',
                'unique:fathers,phone_one,' . $this->student->father->id,
                'unique:fathers,phone_two,' . $this->student->father->id ,
                'unique:employees,phone_number'
            ],
            'parent_full_name' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name'     => __('app.student_full_name'),
            'stage'         => __('app.stage'),
            'class_id'      => __('app.class'),
            'total_fee'     => __('app.total_fee'),
            'school_id'     => __('app.school'),
            'address'       => __('app.address'),
            'phone_one'         => __('app.phone_one'),
            'phone_two'         => __('app.phone_two')
        ];
    }
}
