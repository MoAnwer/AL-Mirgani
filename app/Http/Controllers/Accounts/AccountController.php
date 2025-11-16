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
        $targetDate = $request->query('date') ?? today()->format('Y-m-d');

        $school_id = $request->query('school_id') ?? null;

        $previousBalance = $this->getPerviousDateAmount($this->earning, $targetDate, $school_id) - $this->getPerviousDateAmount($this->expense, $targetDate, $school_id);

        $dailyIncomes = $this->getEntity($this->earning, $targetDate, $school_id, 'income');

        $dailyExpenses = $this->getEntity($this->expense, $targetDate, $school_id, 'expense');

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
                'date' => date('Y-m-d', strtotime($transaction['date'])),
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


    /**
     * 
     * 
     */
    private function getPerviousDateAmount($model, $targetDate, $school_id) 
    {
        return $model->whereDate('date', '<', $targetDate)
                        ->when($school_id, 
                                function($q) use ($school_id) {
                                    $q->where(fn($q) => $q->where('school_id', $school_id)->orWhere('school_id', null));
                                }
                            )
                            ->sum('amount');
    }


    /**
     * 
     * 
     */
    private function getEntity($model, $targetDate, $school_id, $type)
    {
        $result = $model->whereDate('date', $targetDate)
                    ->when($school_id != 0, 
                        function($q) use ($school_id) {
                            $q->where(fn($q) => $q->where('school_id', $school_id)->orWhere('school_id', '=', null));
                        }
                    )
                    ->get()
                    ->map(function ($item) use ($type) {
                        return [
                            'date' => $item->date,
                            'statement' => $item->statement,
                            'amount' => $item->amount,
                            'type'  => $type,
                            'created_at' => $item->created_at, 
                        ];
                    });

        //DON'T TOUCH THIS: This line is required to avoid "Call to a member function getKey() on array" error, 
        return collect($result);
    }
}
