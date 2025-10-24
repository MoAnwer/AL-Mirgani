<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use Carbon\Carbon;

class ArrearsReportController extends Controller
{
    function __construct(private Installment $installment) {}


    public function generateArrearsReport()
    {
        $today = Carbon::today();
        
        $overdueInstallments = $this->installment->where('due_date', '<', $today)
            ->with(['student.class', 'payments']) 
            ->get();


        $reportData = [];

        $arrearsBuckets = $this->arrearsBuckets();

        // Get Overdue installments and arrears logic with categories
        $this->getOverdueInstallments($today, $overdueInstallments, $reportData);

        return view('reports.arrears_report', compact('reportData', 'arrearsBuckets'));
    }

    
    private function getOverdueInstallments($day, $overdueInstallments, &$reportData)
    {
        foreach ($overdueInstallments as $installment) {
            // Paid amount of the installment
            $amountPaid = $installment->payments->sum('paid_amount'); 
            
            // Remaining amount
            $balanceDue = $installment->amount - $amountPaid;

            // analysis Arrears days            
            if ($balanceDue > 0) {
                
                $daysOverdue = abs($day->diffInDays(Carbon::parse($installment->due_date)));

                // (Arrears Logic) 
                $bucket = $this->bucket($daysOverdue);
                
                // Collect report data
                $reportData[] = [
                    'student_name'          => $installment->student->full_name ?? '',
                    'class_name'            => $installment->student->class->name ?? 'غير محدد',
                    'stage'                 => $installment->student->stage ?? 'غير محدد',
                    'installment_number'    => $installment->number ?? '',
                    'due_date'              => date('Y-m-d', strtotime($installment->due_date)),
                    'amount_due'            => $installment->amount ?? 0,
                    'amount_paid'           => $amountPaid ?? 0,
                    'balance_due'           => $balanceDue ?? '',
                    'days_overdue'          => $daysOverdue ?? '',
                    'arrears_bucket'        => $bucket ?? 0,
                ];

                $this->arrearsBuckets()['total'] += $balanceDue;
                $this->arrearsBuckets()[$bucket] += $balanceDue;

            }
        }
    }


    private function arrearsBuckets(): array
    {
        return [
            'total' => 0,
            '1-30' => 0,
            '31-60' => 0,
            '61-90' => 0,
            '90+' => 0,
        ];
    }

    private function bucket($daysOverdue) : string {
        $bucket = '';

        if ($daysOverdue <= 30) {
            $bucket = '1-30';
        } elseif ($daysOverdue <= 60) {
            $bucket = '31-60';
        } elseif ($daysOverdue <= 90) {
            $bucket = '61-90';
        } else {
            $bucket = '90+';
        }

        return $bucket;
    }
}