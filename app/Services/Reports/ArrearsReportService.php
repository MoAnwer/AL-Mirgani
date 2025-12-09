<?php

namespace App\Services\Reports;

use App\Models\{ClassRoom, School, Installment};
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class ArrearsReportService
{

    function __construct(
        private readonly Installment $installment,
        private readonly School $school,
        private readonly ClassRoom $class
    ) {}

    public function report()
    {
        $filters = [
            'school_id'   => request()->query('school_id'),
            'class_id'    => request()->query('class_id'),
            'date'        => request()->query('date'),
        ];

        $today = Carbon::today();

        $currentPage = request()->input('page', 1);

        $overdueInstallments = $this->installment
            ->whereHas('student')
            ->whereDate('due_date', '<', $today)
            ->when(!empty($filters['school_id']), function ($q) use ($filters) {
                $q->whereHas('student', function ($builder) use ($filters) {
                    $builder->where('school_id', $filters['school_id']);
                });
            })
            ->when(!empty($filters['class_id']), function ($q) use ($filters) {
                $q->whereHas('student', function ($builder) use ($filters) {
                    $builder->where('class_id', $filters['class_id']);
                });
            })
            ->when(!empty($filters['date']), function ($q) use ($filters) {
                $q->whereDate('due_date', $filters['date']);
            })
            ->withSum('payments as paid_amount', 'paid_amount')
            ->with(['student:id,full_name,school_id,class_id', 'student.class:id,name', 'payments', 'student.school:id,name'])
            ->where(function ($q) {
                $q->whereRaw('
                    installments.amount > (
                        SELECT SUM(installment_payments.paid_amount) 
                        FROM installment_payments 
                        WHERE installment_payments.installment_id = installments.id AND installment_payments.receipt_number NOT NULL
                    )
                    OR (
                        SELECT SUM(installment_payments.paid_amount) 
                        FROM installment_payments 
                        WHERE installment_payments.installment_id = installments.id AND installment_payments.receipt_number NOT NULL
                    ) IS NULL
                    ');
            })
            ->get();

        $reportData = [];

        $this->getOverdueInstallments($today, $overdueInstallments, $reportData);

        $collection = new Collection($reportData);

        // For make pagination in report data
        $reportData = new LengthAwarePaginator(
            $collection->forPage($currentPage, 15)->values(),
            $collection->count(),
            15,
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

            // Paid amount of the installment by check if there is receipt
            $amountPaid = $installment->payments()->whereHas('receipt')->sum('paid_amount');

            // Old way: $amountPaid = $installment->payments->sum('paid_amount');

            // Remaining amount
            $balanceDue = $installment->amount - $amountPaid;

            $daysOverdue = abs($day->diffInDays(Carbon::parse($installment->due_date)));

            // To ignore the completed installment payment that hav due date equal $day
            $reportData[] = [
                'student_name'          => $installment->student->full_name ?? '-',
                'class_name'            => $installment->student->class->name ?? '-',
                'school_name'           => $installment->student->school->name ?? '-',
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
