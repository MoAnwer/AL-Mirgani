<?php

namespace App\Listeners;

use App\Enums\ExpenseCategoryEnum;
use App\Events\Expense\PayrollPaid;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use App\Notifications\PayrollPaidNotification;
use Illuminate\Support\Facades\Notification;

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
        $this->expense->create([
            'amount'      => $event->payroll->net_salary_paid,
            'category_id' => ExpenseCategory::where('name', ExpenseCategoryEnum::SALARIES)->value('id'),
            'date'        => $event->payroll->payment_date?->toDateString() ?? null,
            'statement'   => __('app.payroll_paid_statement', ['employee' => $event->payroll->employee->full_name, 'month' => $event->payroll->month, 'year' => $event->payroll->year]),
            'user_id'     => auth()->id(),
            'payment_method' => $event->payroll->payment_method,
            'transaction_id' => $event->payroll->transaction_id ?? null
        ]);

        User::chunk(100, function($user) use ($event) {
            Notification::send($user, new PayrollPaidNotification([
                'employee'  => $event->payroll->employee->full_name,
                'month'     => $event->payroll->month,
                'year'      => $event->payroll->year,
                'method'    => $event->payroll->payment_method
            ]));
        });
    }
}
