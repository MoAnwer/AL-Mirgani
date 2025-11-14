<?php

namespace App\Listeners;

use App\Enums\ExpenseCategoryEnum;
use App\Events\Expense\PayrollPaid;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Notifications\PayrollPaidNotification;


class EmployeePayrollIsPaid
{
    /**
     * Create the event listener.
     */
    public function __construct(public Expense $expense) {}

    /**
     * Handle the event.
     */
    public function handle(PayrollPaid $event): void
    {
        // set payment date
        $event->payroll->payment_date = now()->toDateString();
        $event->payroll->save();

        $this->expense->create([
            'amount'      => $event->payroll->net_salary_paid,
            'category_id' => ExpenseCategory::where('name', ExpenseCategoryEnum::SALARIES)->value('id'),
            'date'        => $event->payroll->payment_date,
            'statement'   => __('app.payroll_paid_statement', ['employee' => $event->payroll->employee->full_name, 'month' => $event->payroll->month, 'year' => $event->payroll->year]),
            'user_id'     => auth()->id(),
        ]);

        auth()->user()->notify(new PayrollPaidNotification([
            'employee'  => $event->payroll->employee->full_name,
            'month' => $event->payroll->month,
            'year' => $event->payroll->year
        ]));
    }
}
