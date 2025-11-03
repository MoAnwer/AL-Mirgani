<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\{ClassRoom, Installment, School};
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArrearsReportController extends Controller
{

    private $perPage = 15; 

    function __construct(
        private readonly Installment $installment,
        private readonly School $school, 
        private readonly ClassRoom $class
    ) {}

    public function generateArrearsReport()
    {
         $filters = [
            'school_id'   => request()->query('school_id'),
            'class_id'    => request()->query('class_id'),
            'date'        => request()->query('date'),
        ];

        $today = Carbon::today();

        $currentPage = request()->input('page', 1);
        
        $overdueInstallments = $this->installment
                                ->where('due_date', '<', $today)
                                ->when(!empty($filters['school_id']), function($q) use ($filters) {
                                    $q->whereHas('student', function($builder) use ($filters) {
                                        $builder->where('school_id', $filters['school_id']);
                                    });
                                })
                                ->when(!empty($filters['class_id']), function($q) use ($filters) {
                                    $q->whereHas('student', function($builder) use ($filters) {
                                        $builder->where('class_id', $filters['class_id']);
                                    });
                                })
                                ->when(!empty($filters['date']), function($q) use ($filters) {
                                    $q->where('due_date', $filters['date']);
                                })
                                ->with(['student.class', 'payments']) 
                                ->get();


        $reportData = [];

        $this->getOverdueInstallments($today, $overdueInstallments, $reportData);

        $collection = new Collection($reportData);

        $offset = ($currentPage * $this->perPage) - $this->perPage;

        // For make pagination in report data
        $reportData = new LengthAwarePaginator(
            $collection->forPage($currentPage, $this->perPage)->values(), 
            $collection->count(), 
            $this->perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $schools = $this->school->get();
        $classes = $this->class->get();

        return view('reports.arrears_report', compact('reportData', 'schools', 'classes'));
    }

    
    private function getOverdueInstallments($day, $overdueInstallments, &$reportData)
    {
        foreach ($overdueInstallments as $installment) {
            // Paid amount of the installment
            $amountPaid = $installment->payments->sum('paid_amount'); 
            
            // Remaining amount
            $balanceDue = $installment->amount - $amountPaid;
            
            $daysOverdue = abs($day->diffInDays(Carbon::parse($installment->due_date)));

            // To ignore the completed installment payment that hav due date equal $day
            // ما تقابض في السطر دا عشان دا هو البخلي الاقساط العندها ملبغ متاخر يساوي 0 يطنشها 
            if ($balanceDue == 0) continue;

            $reportData[] = [
                'student_name'          => $installment->student->full_name ?? '',
                'class_name'            => $installment->student->class->name ?? 'غير محدد',
                'installment_number'    => $installment->number ?? '',
                'due_date'              => date('Y-m-d', strtotime($installment->due_date)),
                'amount_due'            => $installment->amount ?? 0,
                'amount_paid'           => $amountPaid ?? 0,
                'balance_due'           => $balanceDue ?? '',
                'days_overdue'          => $daysOverdue ?? '',
            ];

        }
    }
}