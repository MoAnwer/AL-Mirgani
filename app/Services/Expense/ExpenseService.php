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


    public function expensesList() 
    {
        $filters = [
            'category_id' => request()->query('category_id'),
            'school_id'   => request()->query('school_id'),
            'date'        => request()->query('date'),
            'payment_method' => request()->query('payment_method')
        ];
       
        $data = $this->expense
                        ->query()
                        ->with('school:id,name', 'category:id,name')
                        ->when(!empty($filters['category_id']), 
                            function($q) use ($filters) {
                                $q->where('category_id', $filters['category_id']);
                            }
                        )
                        ->when(!empty($filters['school_id']), 
                            function($q) use ($filters) {
                                $q->where('school_id', $filters['school_id']);
                            }
                        )
                        ->when(!empty($filters['date']), 
                            function($q) use ($filters) {
                                $q->whereDate('date', $filters['date']);
                            }
                        )
                        ->when(
                            !empty($filters['payment_method']),
                            function ($q) use ($filters) {
                                $q->where('payment_method', $filters['payment_method']);
                            }
                        )
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