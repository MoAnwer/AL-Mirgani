<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Student;

class DashboardController extends Controller
{

    public function __construct(
        private readonly Student $student,
        private readonly Expense $expense,
        private readonly ExpenseCategory $expenseCategories,
        private readonly Earning $earning
    ) {}

    /**
     * Show Dashboard Page with stats
     */
    public function home()
    {
        $totalRevenue = $this->earning->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');

        $totalExpenses = $this->expense->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');

        $latestStudents = $this->student->latest('created_at')->take(3)->get([
            'id',
            'full_name',
            'stage',
            'created_at'
        ]);

        return view('dashboard.dashboard', [
            'title'         => __('app.app_name'),
            'totalRevenue'  => number_format($totalRevenue),
            'totalExpenses' => number_format($totalExpenses),
            'totalProfit'   => number_format($totalRevenue - $totalExpenses),
            'latestStudents' => $latestStudents,
        ]);
    }
}
