<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GeneralExpenseReportController extends Controller
{

    function __construct(private Expense $expense, private School $school) {}


   /**
     * Calculate general expenses report by start date, end date, and school filters
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function generateGeneralExpenseSummary(Request $request)
    {
        $schoolId = $request->input('school_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');     

        $query = $this->expense
                        ->query()
                        ->when($schoolId,  fn($q, $school_id)     => $q->where('school_id', $school_id))
                        ->when($startDate, fn($q, $startDate)     => $q->whereDate('date', '>=', Carbon::parse($startDate)->toDateString()))
                        ->when($endDate,   fn($q, $endDate)       => $q->whereDate('date', '<=', Carbon::parse($endDate)->toDateString()));

        
        $totalExpenses = $query->sum('amount');

        $reportData = [
            'total_amount' => number_format($totalExpenses ?? 0),
        ];

        $schools = $this->school->get();

        return view('reports.general_expense_summary', compact('reportData', 'schoolId', 'startDate', 'endDate', 'schools'));
    }
}
