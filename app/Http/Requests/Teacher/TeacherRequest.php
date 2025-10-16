<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'name'      => 'required',
            'salary'    => 'required',
            'phone'     => 'required',
            'rule'      => 'required'
        ];
    }

    public function attributes(): array
    {
        return [
            'name'      => __('app.teacher_name'),
            'salary'    => __('app.salary'),
            'phone'     => __('app.phone_one'),
            'rule'      => __('app.rule')
        ];
    }
}
