<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentHealthyHistoryRequest extends FormRequest
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
            'diagnosis'     =>  ['nullable', 'string', 'max:255'],
            'medication'    =>  ['nullable', 'string', 'max:255'],
            'notes'         =>  ['nullable', 'string', 'max:255'],
        ];
    }


    public function attributes()
    {
        return [
            'diagnosis'     =>  __('app.diagnosis'),
            'medication'    =>  __('app.medication'),
            'notes'         =>  __('app.notes'),
        ];
    }
}
