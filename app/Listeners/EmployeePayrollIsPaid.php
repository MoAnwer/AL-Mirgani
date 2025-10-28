<?php

namespace App\Listeners;

use App\Enums\ExpenseCategoryEnum;
use App\Events\Expense\PayrollPaid;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
            'date'        => $event->payroll->payment_date,
            'statement'   => "دفع مرتب الموظف {$event->payroll->employee->full_name}  لشهر {$event->payroll->month} لسنة {$event->payroll->year} " , 
            'user_id'     => auth()->id(),
        ]);
    }
}
