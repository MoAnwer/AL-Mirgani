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
            'full_name' => ['required', 'string'],
            'stage'     => ['required'],
            'address'   => ['required'],
            'total_fee' => ['required', 'integer'],
            'class_id'  => ['required'],
            'school_id' => ['required'],
            'phone_one' => ['nullable'],
            'phone_two' => ['nullable'],
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
            'address'       => __('app.address')
        ];
    }
}
