<?php

namespace App\Listeners;

use App\Enums\ExpenseCategoryEnum;
use App\Events\Expense\SalaryPaid;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TeacherSalaryPaid
{
    /**
     * Create the event listener.
     */
    public function __construct(public Expense $expense) {}

    /**
     * Handle the event.
     */
    public function handle(SalaryPaid $event): void
    {
        $this->expense->create([
            'amount'      => $event->salaryPayment->amount,
            'category_id' => ExpenseCategory::where('name', ExpenseCategoryEnum::SALARIES)->get()[0]->id,
            'date'        => $event->salaryPayment->payment_date,
            'statement'   => $event->salaryPayment->statement, 
            'user_id'     => auth()->user()->id,
        ]);
    }
}
