<?php

namespace App\Services\Reports;

use App\Models\{Expense, School, Earning};
use Illuminate\Http\Request;

final readonly class AccountsReportService
{
    public function __construct(
        private Expense $expense,
        private Earning $earning,
        private School $school
    ) {}

    /**
     * Show the daily accounting data report (expenses, earning)
     *
     * @param Request $request
     * @return View
     **/
    public function report(Request $request)
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

        $paymentMethods = ['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')];

        return view('accounts.daily_report', compact('paymentMethods', 'targetDate', 'previousBalance', 'reportData', 'dailyIncomeTotal', 'dailyExpenseTotal', 'finalDailyBalance', 'schools'));
    }


    /**
     * Get the forward balance (pervious date amount)
     * 
     * @param $model
     * @param $targetDate
     * @param $school_id
     */
    private function getPerviousDateAmount($model, $targetDate, $school_id)
    {
        return $model->whereDate('date', '<', $targetDate)
            ->when(
                $school_id,
                function ($q) use ($school_id) {
                    $q->where(fn($q) => $q->where('school_id', $school_id)->orWhere('school_id', null));
                }
            )
            ->when(
                request()->query('payment_method'),
                function ($q) {
                    $q->where(fn($q) => $q->where('payment_method', request()->query('payment_method')));
                }
            )
            ->sum('amount');
    }


    /**
     *  Get finance entity (earning, expenses)
     * 
     * @param string $model
     * @param $targetDate
     * @param $school_id
     * @param $type
     */
    private function getEntity($model, $targetDate, $school_id, $type)
    {
        $result = $model->whereDate('date', $targetDate)
            ->when($school_id != 0, fn($q) => $q->where(fn($q) => $q->where('school_id', $school_id)->orWhere('school_id', '=', null)))
            ->when(request()->query('payment_method'), fn ($q) => $q->where(fn($q) => $q->where('payment_method', request()->query('payment_method'))))
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
