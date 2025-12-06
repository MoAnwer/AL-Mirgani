<?php

namespace App\Services\Payroll;

use App\Enums\PaymentStatusEnum;
use App\Events\Expense\PayrollPaid;
use App\Http\Requests\Payroll\StorePayrollRequest;
use App\Models\{Employee, EmployeePayroll};
use App\Rules\{RequiredIfBankak, UniqueInTables};
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
        $paymentMethod = $request->get('payment_method');
        $transactionId = $request->input('transaction_id');

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
            ->when($paymentMethod, function ($q, $paymentMethod) {
                return $q->where('payment_method', $paymentMethod);
            })
            ->when($transactionId, fn ($q) => $q->where('transaction_id', $transactionId))
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
    public function store(StorePayrollRequest $request)
    {
        $request->validated();

        $employee = $this->employee->findOrFail($request->employee_id);

        $netSalary = $employee->salary;
        
        $payroll = null;

        if (empty($request->payment_method) || $request->payment_method == "كاش") {
            $payroll = $this->employee_payroll->create([
                'employee_id' => $request->employee_id,
                'month' => $request->month,
                'year' => $request->year,
                'basic_salary_snapshot' => $employee->salary,
                'total_fixed_allowances' => 0,
                'total_variable_additions' => 0,
                'total_deductions' => 0,
                'net_salary_paid' => $netSalary ?? 0,
                'school_total_cost' => 0,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method ?? "كاش",
                'payment_date'  => $request->payment_date ?? null,
            ]);
        } else {
            $payroll = $this->employee_payroll->create([
                'employee_id' => $request->employee_id,
                'month' => $request->month,
                'year' => $request->year,
                'basic_salary_snapshot' => $employee->salary,
                'total_fixed_allowances' => 0,
                'total_variable_additions' => 0,
                'total_deductions' => 0,
                'net_salary_paid' => $netSalary ?? 0,
                'school_total_cost' => 0,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method ?? "كاش",
                'transaction_id' => $request->transaction_id,
                'payment_date'  => $request->payment_date ?? null,
            ]);
        }

        if ($payroll->isPaid()) {
            event(new PayrollPaid($payroll));
        }

        return to_route('payroll.index')->with('message', __('app.create_successful', ['attribute' => $employee->full_name]));
    }

    /**
     * Show page of employee payroll
     * 
     * @param EmployeePayroll $payroll
     * @return View
     */
    public function show(EmployeePayroll $payroll)
    {
        $payroll->load(['employee', 'details.item']);

        // verify employee is exist
        if ($payroll->employee == null) return back()->with('error', __('app.empty_message', ['attributes' => __('app.employee')]));

        $additions = $payroll->details->where('item.type', 'Addition');
        $deductions = $payroll->details->where('item.type', 'Deduction');

        return view('payroll.show-payroll', compact('payroll', 'additions', 'deductions'));
    }


    /**
     * Edit page of employee payroll
     * 
     * @param EmployeePayroll $payroll
     * @return View
     */
    public function editPage(EmployeePayroll $payroll)
    {
        if ($payroll->isPaid()) {
            return to_route('payroll.show', $payroll->id)->with('error', __('app.payroll_paid_error'));
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
        try {

            $data = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'month' => 'required|integer|min:1|max:12',
                'year' => 'required|integer|min:2000',
                'basic_salary_snapshot' => 'required|numeric|min:0|max_digits:15',
                'payment_status' => 'required|in:Pending,Paid,Failed',
                'payment_date' => 'nullable',
                'payment_method'    => ['nullable'],
                'transaction_id'    =>  [
                    'sometimes',
                    'max_digits:15',
                    $request->transaction_id != null ? new RequiredIfBankak() : '',
                    $request->transaction_id == null && $payroll->transaction_id == null && $request->payment_method == 'بنكك' ? new RequiredIfBankak() : '',
                    $request->transaction_id != $payroll->transaction_id ? new UniqueInTables(
                        tables: ['earnings', 'expenses', 'registration_fees', 'installment_payments', 'employee_payrolls'],
                        column: 'transaction_id',
                    ) : '',
                ],
            ]);

            // Check if transaction_id is null and payment_date is bankak
            if ($data['transaction_id'] == null && $data['payment_method'] == 'بنكك') {
                // make the send transaction id == old payroll transaction id
                $data['transaction_id'] = $payroll->transaction_id;
            }

            // Check if transaction_id is null and payment_date is not bankak
            if ($data['transaction_id'] == null && $data['payment_method'] != 'بنكك') {
                // make the send transaction id equal null
                $data['transaction_id'] = null;
            }

            DB::transaction(function () use ($request, $payroll, $data) {

                $originalBasicSalary = $payroll->basic_salary_snapshot;

                $payroll->update($data);

                if ($originalBasicSalary != $request->basic_salary_snapshot) {
                    $this->recalculatePayrollSummary($payroll);
                }

                // Register new expense in expenses table 
                if ($payroll->isPaid()) {
                    event(new PayrollPaid($payroll));
                }
            });

            return to_route('payroll.show', $payroll->id)->with('message', __('app.payroll_saved'));
        } catch (\Exception $e) {

            report($e);

            if ($e->getCode() == 23000) {
                return back()->with('error', __('validation.unique', ['attribute' => __('app.duplicate_paid_payroll')]));
            }

            return back()->with('error', $e->getMessage());
        }
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

        if (!$payroll->isPaid()) {
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

        return to_route('payroll.index')->with('message', __('app.delete_successful', ['attribute' => $employeeName . ' ' . __('app.salary')]));
    }
}
