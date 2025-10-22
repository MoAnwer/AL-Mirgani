<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Expense;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function showDailyAccount(Request $request)
    {
        // 1. تحديد اليوم المستهدف
        $targetDate = now();
        
        // 2. حساب الرصيد المرحل السابق (Accumulated Balance before today)
        $previousIncome = Earning::whereDate('date', '<', $targetDate)->sum('amount');
        $previousExpense = Expense::whereDate('date', '<', $targetDate)->sum('amount');
        $previousBalance = $previousIncome - $previousExpense;

        // 3. جلب حركات اليوم المستهدف (الإيرادات والمصروفات)
        $dailyIncomes = Earning::whereDate('date', $targetDate)->get()->map(function ($item) {
            return [
                'date' => $item->date,
                'statement' => $item->statement,
                'amount' => $item->amount,
                'type'  => 'income',
                'created_at' => $item->created_at, // استخدم created_at للترتيب الزمني
            ];
        });

        $dailyExpenses = Expense::whereDate('date', $targetDate)->get()->map(function ($item) {
            return [
                'date' => $item->date,
                'statement' => $item->statement,
                'amount' => $item->amount,
                'type'  => 'expense',
                'created_at' => $item->created_at, // استخدم created_at للترتيب الزمني
            ];
        });

        // 4. دمج وتصنيف الحركات (Merge and Sort)
        $dailyTransactions = $dailyIncomes->merge($dailyExpenses)->sortBy('created_at');

        // 5. إعداد البيانات للعرض وحساب الرصيد الجاري
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
        
        $finalDailyBalance = $balance; // الرصيد النهائي بعد حركات اليوم
        
        return view('accounts.daily_report', compact('targetDate', 'previousBalance', 'reportData', 'dailyIncomeTotal', 'dailyExpenseTotal', 'finalDailyBalance'));
    }
}
