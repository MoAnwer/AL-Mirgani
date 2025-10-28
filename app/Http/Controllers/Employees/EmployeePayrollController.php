<?php

namespace App\Http\Controllers\Employees;

use App\Enums\PaymentStatusEnum;
use App\Events\Expense\PayrollPaid;
use App\Http\Controllers\Controller;
use App\Models\{Employee, EmployeePayroll};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeePayrollController extends Controller
{

    public function __construct(
        private Employee $employee,
        private EmployeePayroll $employee_payroll,
    ) {}


    public function index(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');
        $employeeId = $request->get('employee_id');
        $paymentStatus = $request->get('payment_status');

        $payrolls = $this->employee_payroll->with('employee') 
            ->when($month, function ($q, $month) {
                return $q->where('month', $month);
            })
            ->when($year, function ($q, $year) {
                return $q->where('year', $year);
            })
            ->when($employeeId, function ($q, $employeeId) {
                return $q->where('employee_id', $employeeId);
            })
            ->when($paymentStatus , function($q, $paymentStatus) {
                return $q->where('payment_status', $paymentStatus);
            })
            ->orderByDesc('id')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->paginate(15);

        $employees = $this->employee->select('id', 'full_name')->get();

        $paymentsTypes = PaymentStatusEnum::cases();

        return view('payroll.payroll-list', compact('payrolls', 'employees', 'paymentsTypes'));
    }


    /**
     * Create new employee payroll page
     * 
     * @return View
     */
    public function create()
    {
        $employees = $this->employee->select('id', 'full_name', 'salary', 'fixed_allowances')->get(); 
        
        $defaultMonth = now()->month;
        $defaultYear = now()->year;

        return view('payroll.create_summary', compact('employees', 'defaultMonth', 'defaultYear'));
    }

    /**
     * Show page of employee payroll
     * @param EmployeePayroll $payroll
     * @return View
     */
    public function show(EmployeePayroll $payroll)
    {
        $payroll->load(['employee', 'details.item']);

        $additions = $payroll->details->where('item.type', 'Addition');
        $deductions = $payroll->details->where('item.type', 'Deduction');

        return view('payroll.show-payroll', compact('payroll', 'additions', 'deductions'));
    }


    /**
     * Edit page of employee payroll
     * @param EmployeePayroll $payroll
     * @return View
     */
    public function edit(EmployeePayroll $payroll)
    {
        if ($payroll->payment_status == 'Paid') {
            return to_route('payroll.show', $payroll->id)->with('error', 'لا يمكن تعديل كشف راتب تم دفعه بالفعل.');
        }

        $employees = $this->employee->select('id', 'full_name')->get();

        return view('payroll.edit-payroll', compact('payroll', 'employees'));
    }

    
    /**
     * Update employee payroll data
     * 
     * @param Request $request
     * @param EmployeePayroll $payroll
     * @return View
     */
    public function update(Request $request, EmployeePayroll $payroll)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000',
            'basic_salary_snapshot' => 'required|numeric|min:0',
            'payment_status' => 'required|in:Pending,Paid,Failed',
            'payment_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request, $payroll) {
            
            $originalBasicSalary = $payroll->basic_salary_snapshot;
            
            tap($payroll->update($request->all()));

            if ($originalBasicSalary != $request->basic_salary_snapshot) {
                $this->recalculatePayrollSummary($payroll);
            }
            
            
            // Register new expense in expenses table 
            if ($payroll->payment_status == 'Paid') {
                event(new PayrollPaid($payroll));
            }

        });

        return to_route('payroll.show', $payroll->id)->with('message', 'تم تحديث ملخص كشف الراتب بنجاح.');
    }

    /**
     * Recalculate payroll when old basic salary does not equal the sended basic salary snapshot
     * 
     * @param EmployeePayroll $payroll
     * @return void
     */
    private function recalculatePayrollSummary(EmployeePayroll $payroll) : void
    {
        $payroll->load('details.item');

        $totalVariableAdditions = $payroll->details
            ->where('item.type', 'Addition')
            ->sum('amount');
            
        $totalDeductions = $payroll->details
            ->whereIn('item.type', ['Deduction', 'Tax'])
            ->sum('amount');

        $grossSalary = $payroll->basic_salary_snapshot + $payroll->total_fixed_allowances + $totalVariableAdditions;
        $netSalary = $grossSalary - $totalDeductions;
        
        $payroll->update([
            'total_variable_additions' => $totalVariableAdditions,
            'total_deductions' => $totalDeductions,
            'net_salary_paid' => $netSalary,
        ]);
    }


    public function payrollInvoice(EmployeePayroll $payroll) {

        if ($payroll->payment_status != PaymentStatusEnum::PAID->value) {
            return back();
        }
        
        $additions = $payroll->details
            ->where('item.type', 'Addition')
            ->all();

        $deductions = $payroll->details
            ->whereIn('item.type', ['Deduction', 'Tax'])
            ->all();


        return view('test-invoice', compact('payroll', 'additions', 'deductions'));
    }
}