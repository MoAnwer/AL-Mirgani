<?php

namespace App\Services\Expense;

use Exception;
use App\Models\{Expense, ExpenseCategory, School, User};
use App\Notifications\NewExpenseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ExpenseService
{
    public function __construct(private Expense $expense, private ExpenseCategory $expense_category, private School $school) {}


    /**
     * Expenses list with filters functionality
     * 
     * @return View
     */
    public function expensesList()
    {
        $filters = [
            'category_id'    => request()->query('category_id'),
            'school_id'      => request()->query('school_id'),
            'date'           => request()->query('date'),
            'payment_method' => request()->query('payment_method'),
            'transaction_id' => request()->query('transaction_id'),
        ];

        $data = $this->expense
            ->query()
            ->with('school:id,name', 'category:id,name')
            ->when($filters['category_id'], fn($q) => $q->where('category_id', $filters['category_id']))
            ->when($filters['school_id'], fn ($q) => $q->where('school_id', $filters['school_id']))
            ->when($filters['date'], fn($q) => $q->whereDate('date', $filters['date']))
            ->when($filters['payment_method'], fn ($q) => $q->where('payment_method', $filters['payment_method']))
            ->when($filters['transaction_id'], fn($q) => $q->where('transaction_id', $filters['transaction_id']))
            ->latest()
            ->paginate(15);

        $paymentMethods = ['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')];

        return view('expenses.expenses-list', [
            'expenses'   => $data,
            'categories' => $this->expense_category->pluck('id', 'name'),
            'schools'    => $this->school->pluck('id', 'name'),
            'paymentMethods'    => $paymentMethods
        ]);
    }


    /**
     * Create new expenses 
     * 
     * @param $request
     * @return View|RedirectResponse
     */
    public function create(Request $request)
    {

        try {

            $expense = $this->expense->create($request->validated());

            Notification::sendNow(User::all(), new NewExpenseNotification($expense));

            return back()->with('message', __('app.create_successful', ['attribute' => __('app.expense')]));
        } catch (Exception $e) {
            report($e);
            return back()->with('error', __('app.error'));
        }
    }
}
