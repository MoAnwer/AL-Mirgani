<?php

namespace App\Http\Controllers\Reports;

use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\EmployeePayroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollSummaryReportController extends Controller
{
    function __construct(private EmployeePayroll $payroll) {}

    
    /** Employee payrolls report with year, month filtering options
     * @param Request $request
     */
    public function generateSummaryReport(Request $request)
    {
        $targetYear = $request->input('year', now()->year);
        
        $payrollSummaries = $this->payroll
            ->select(
                DB::raw('SUM(basic_salary_snapshot) as total_basic_salary'),
                DB::raw('SUM(total_fixed_allowances) as total_allowances'),
                DB::raw('SUM(total_variable_additions) as total_additions'),
                DB::raw('SUM(total_deductions) as total_deductions'),
                DB::raw('SUM(net_salary_paid) as total_net_paid'),
                'month',
                'year'
            )
            ->where('year', $targetYear)
            ->where('payment_status', PaymentStatusEnum::PAID->value)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->toArray();
            
        $reportData = $this->formatReportData($payrollSummaries);

        return view('reports.payroll_summary_report', compact('reportData', 'targetYear'));
    }

    /**
     * Format and coordinate data to view it
     */
    private function formatReportData($summaries)
    {
        $data = [];

        $months = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
        ];

        foreach ($summaries as $summary) {
            $data[] = [
                'period'                => $months[$summary['month']] . ' ' . $summary['year'],
                'basic_salary'          => $summary['total_basic_salary'],
                'total_allowances'      => $summary['total_allowances'],
                'total_deductions'      => $summary['total_deductions'],
                'total_additions'       => $summary['total_additions'],
                'net_paid_amount'       => number_format($summary['total_net_paid']),
            ];
        }

        return $data;
    }
}
