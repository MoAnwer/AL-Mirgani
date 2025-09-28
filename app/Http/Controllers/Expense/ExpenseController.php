<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\CreateExpenseRequest;
use App\Services\Expense\ExpenseService;
use App\Models\{School, ExpenseCategory};

class ExpenseController extends Controller
{

    public function __construct(
        private ExpenseService $service
    )
    {
        
    }
    public function index()
    {
        return view('expenses.expenses-list');
    }

    public function create()
    {
        return view('expenses.create-expense-form', [
            'categories' => ExpenseCategory::pluck('id', 'name'),
            'schools'    => School::pluck('id', 'name'),
        ]);
    }

    public function store(CreateExpenseRequest $request)
    {
        return $this->service->create($request);
    }
}
