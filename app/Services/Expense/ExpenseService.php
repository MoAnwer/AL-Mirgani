<?php

namespace App\Services\Expense;

use App\Models\Expense;
use Exception;
use Illuminate\Http\Request;

class ExpenseService 
{
    public function __construct(private Expense $expense) {}


    public function expensesList() 
    {
        return view('expenses.expenses-list', [
            'expenses'      => $this->expense->with('school:id,name', 'category:id,name')->latest()->paginate(15)
        ]);
    }


    public function create(Request $request)
    {

        try {
            $this->expense->create($request->validated());
            return back()->with('message', __('app.create_successful', ['attribute' => __('app.expense')]));
        } catch (Exception $e) {
            report($e);
            return back()->with('error', __('app.error'));
        }
    }
}