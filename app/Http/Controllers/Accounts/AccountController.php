<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Expense;
use App\Models\School;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(
        private Expense $expense, 
        private Earning $earning, 
        private School $school
    ) {}

    public function showDailyAccount(Request $request)
    {
        $targetDate = $request->get('date') ?? today()->format('Y-m-d');
        $school_id = $request->get('school_id') ?? 0;

        $previousIncome = $this->earning->whereDate('date', '<', $targetDate)
                                    ->when($school_id != 0, 
                                        function($q) use ($school_id) {
                                            $q->where('school_id', $school_id);
                                        }
                                    )
                                    ->sum('amount');

        $previousExpense = $this->expense->whereDate('date', '<', $targetDate)
                                ->when($school_id != 0, 
                                    function($q) use ($school_id) {
                                        $q->where('school_id', $school_id);
                                    }
                                )
                                ->sum('amount');

        $previousBalance = $previousIncome - $previousExpense;

        $dailyIncomes = $this->earning->whereDate('date', $targetDate)
                                ->when($school_id != 0, 
                                    function($q) use ($school_id) {
                                        $q->where('school_id', $school_id);
                                    }
                                )
                                ->get()
                                ->map(function ($item) {
                                    return [
                                        'date' => $item->date,
                                        'statement' => $item->statement,
                                        'amount' => $item->amount,
                                        'type'  => 'income',
                                        'created_at' => $item->created_at, 
                                    ];
                                });

        //DON'T TOUCH THIS: This line is required to avoid "Call to a member function getKey() on array" error, 
        $dailyIncomes = collect($dailyIncomes);
        

        $dailyExpenses = $this->expense->whereDate('date', $targetDate)
                                    ->when($school_id != 0, 
                                        function($q) use ($school_id) {
                                            $q->where('school_id', $school_id);
                                        }
                                    )
                                    ->get()
                                    ->map(function ($item) {
                                        return [
                                            'date' => $item->date,
                                            'statement' => $item->statement,
                                            'amount' => $item->amount,
                                            'type'  => 'expense',
                                            'created_at' => $item->created_at, 
                                        ];
                                    });

        //DON'T TOUCH THIS: This line is required to avoid "Call to a member function getKey() on array" error, 
        $dailyExpenses = collect($dailyExpenses);

        $dailyTransactions = $dailyIncomes->merge($dailyExpenses)->sortBy('created_at');

        $balance = $previousBalance;

        $reportData = [];

        $dailyIncomeTotal = 0;
        
        $dailyExpenseTotal = 0;

        
        foreach ($dailyTransactions as $transaction) {
            if ($transaction['type'] === 'income') {
                $balance += $transaction['amount'];
                $dailyIncomeTotal += $transaction['amount'];
            } else {
                $balance -= $transaction['amount'];
                $dailyExpenseTotal += $transaction['amount'];
            }

            $reportData[] = [
                'date' => $transaction['date'],
                'statement' => $transaction['statement'],
                'type' => $transaction['type'],
                'amount' => $transaction['amount'],
                'running_balance' => $balance,
            ];
        }
        
        $finalDailyBalance = $balance;

        $schools = $this->school->pluck('id', 'name');
        
        return view('accounts.daily_report', compact('targetDate', 'previousBalance', 'reportData', 'dailyIncomeTotal', 'dailyExpenseTotal', 'finalDailyBalance', 'schools'));
    }
}
