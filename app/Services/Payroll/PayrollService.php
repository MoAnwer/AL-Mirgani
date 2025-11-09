<?php

namespace App\Services\Payroll;

use App\Enums\PaymentStatusEnum;
use App\Events\Expense\PayrollPaid;
use App\Http\Requests\Employee\StoreEmployeePayrollRequest;
use App\Models\{Employee, EmployeePayroll};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


final readonly class PayrollService
{
    public function __construct(
        private readonly Employee $employee,
        private readonly EmployeePayroll $employee_payroll,
    ) {}

    /**
     * Show payrolls list
     * 
     * @return View
     */
    public function payrollsList(Request $request)
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
            ->when($paymentStatus, function ($q, $paymentStatus) {
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
     * Show create page of employee payroll
     * 
     * @return View
     */
    public function createPage()
    {
        $employees = $this->employee->select('id', 'full_name', 'salary')->get();

        $defaultMonth = now()->month;
        $defaultYear = now()->year;

        return view('payroll.create_summary', compact('employees', 'defaultMonth', 'defaultYear'));
    }

    /**
     * Store payroll
     * 
     * @return View
     */
    public function store(StoreEmployeePayrollRequest $request)
    {
        $request->validated();

        $employee = $this->employee->findOrFail($request->employee_id);

        $variableAdditions = (float) $request->total_fixed_allowances;
        $variableDeductions = (float) $request->total_variable_additions;

        $totalAdditions = $employee->fixed_allowances + $variableAdditions;
        $totalDeductions = $employee->compulsory_deduction + $variableDeductions;
        $grossSalary = $employee->salary + $totalAdditions;
        $netSalary = $grossSalary - $totalDeductions;


        $this->employee_payroll->create([
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
    public function editPage(EmployeePayroll $payroll)
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
    private function recalculatePayrollSummary(EmployeePayroll $payroll): void
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


    /**
     * Print Payroll invoice page
     * @param EmployeePayroll $payroll
     */
    public function payrollInvoice(EmployeePayroll $payroll)
    {

        if ($payroll->payment_status != PaymentStatusEnum::PAID->value) {
            return back();
        }

        $additions = $payroll->details
            ->where('item.type', 'Addition')
            ->all();

        $deductions = $payroll->details
            ->whereIn('item.type', ['Deduction', 'Tax'])
            ->all();


        return view('payroll.payroll_invoice', compact('payroll', 'additions', 'deductions'));
    }


    /**
     * Delete Employee Payroll Page 
     * @param EmployeePayroll $payroll
     */
    public function delete(EmployeePayroll $payroll)
    {
        return view('payroll.delete-payroll', compact('payroll'));
    }


    /**
     * Destroy payroll
     * @param EmployeePayroll $payroll
     */
    public function destroy(EmployeePayroll $payroll)
    {

        $employeeName = $payroll->employee->full_name;

        // delete details of payroll
        $payroll->details()->forceDelete();

        // delete payroll
        $payroll->forceDelete();

        return to_route('payroll.index')->with('message', __('app.delete_successful', ['attribute' => $employeeName . " كشف راتب "]));
    }
}
