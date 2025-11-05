<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeePayrollRequest;
use App\Models\Employee;
use App\Models\EmployeePayroll;

class PayrollProcessorController extends Controller
{
    function __construct(private Employee $employee, private EmployeePayroll $employeePayroll) {}


    public function processAndStore(StoreEmployeePayrollRequest $request)
    {
        $request->validated();
        
        $employee = $this->employee->findOrFail($request->employee_id);
        
        $variableAdditions = (float) $request->total_fixed_allowances;
        $variableDeductions = (float) $request->total_variable_additions;
        
        $totalAdditions = $employee->fixed_allowances + $variableAdditions;
        $totalDeductions = $employee->compulsory_deduction + $variableDeductions;
        $grossSalary = $employee->salary + $totalAdditions;
        $netSalary = $grossSalary - $totalDeductions;
        

        $this->employeePayroll->create([
            'employee_id' => $request->employee_id,
            'month' => $request->month,
            'year' => $request->year,
            'basic_salary_snapshot' => $employee->salary,
            'total_fixed_allowances' => $employee->fixed_allowances ?? 0,
            'total_variable_additions' => $variableAdditions ?? 0,
            'total_deductions' => $totalDeductions ?? 0,
            'net_salary_paid' => $netSalary ?? 0,
            'school_total_cost' => 0,
            'payment_status' => $request->payment_status,
        ]);
        
        
        return to_route('payroll.index')->with('message', 'تمت معالجة وحفظ كشف راتب ' . $employee->full_name . ' بنجاح!');
    }
}