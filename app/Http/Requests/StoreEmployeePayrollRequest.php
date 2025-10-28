<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmployeePayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // يجب تعديلها لتتناسب مع صلاحيات المستخدم
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2020', 'max:' . (now()->year + 1)],
            'payment_date' => ['nullable', 'date'],
            'payment_status' => ['required', Rule::in(['Pending', 'Paid', 'Failed'])],
            
            // إضافة قواعد للتحقق من عدم تكرار كشف الراتب لنفس الشهر والسنة
            'employee_id' => [
                Rule::unique('employee_payrolls', 'employee_id')->where(function ($query) {
                    return $query->where('month', $this->month)
                                 ->where('year', $this->year);
                })
            ],
            
            // الحقول التي يجب أن تكون موجودة افتراضياً أو يتم جلبها من نموذج الموظف
            'total_deductions' => ['required', 'numeric', 'min:0'],
            'total_fixed_allowances' => ['required', 'numeric', 'min:0'],
            'total_variable_additions' => ['required', 'numeric', 'min:0'],
            // وغيرها من الحقول المُجمّعة...
        ];
    }

    public function messages()
    {
        return [
            'unique' => 'تم دفع المرتب لهذا الموظف بالفعل لهذا الشهر',
        ];
    }
}