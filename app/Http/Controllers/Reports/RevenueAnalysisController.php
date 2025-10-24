<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\{ClassRoom, School, Student};

class RevenueAnalysisController extends Controller
{
    function __construct(private Student $student, private ClassRoom $class, private School $school) {}

    public function revenueBySchool()
    {
        $school_id = request()->query('school_id') ?? 0;
        
        $startDate = request()->query('start_date') ?? date('Y-m-d', strtotime(now()->startOfYear()->toString()));

        $endDate = request()->query('end_date') ??  date('Y-m-d', strtotime(now()->endOfYear()->toString()));

        $classes = $this->class->all();
        
        // Check $school_id is not null to get school name or set the all_schools instead
        $schoolName = match ($school_id == 0) {
            true    => trans('app.all_schools'),
            false   => $this->school->findOrFail($school_id)->name
        };

        $reportData = [];
        
        $classTotalFees = 0;
        $classTotalPaid = 0;
        $classTotalDiscount = 0;

        foreach ($classes as $class) {

            // Get students with classes and school
            $students = $this->student
                            ->whereBetween('created_at', [$startDate, $endDate])
                            ->where('class_id', $class->id)
                            ->when($school_id != 0, function ($q) use ($school_id) {
                                $q->where('school_id', $school_id);
                            })
                            ->get();
            
            // Student count by class
            $studentCount = $students->count();
            
            $grossFees = $students->sum('total_fee');
            $discountAmount = $students->sum('discount');

            $netFees = $grossFees;
            
            // Revenue of each student
            $totalPaid = $students->sum(function ($student) use ($startDate, $endDate) {
                return $student->totalPaidBetween($startDate, $endDate);
            });

            // Calculate Balances And Collections Rate
            $balanceDue = $netFees - $totalPaid;
            $collectionRate = ($netFees > 0) ? ($totalPaid / $netFees) * 100 : 0;
            
            // Collect Totals
            $classTotalFees += $netFees;
            $classTotalPaid += $totalPaid;

            $reportData[] = [
                'class_name' => $class->name,
                'student_count' => $studentCount,
                'net_fees' => $netFees,
                'total_paid' => $totalPaid,
                'balance_due' => $balanceDue,
                'collection_rate' => number_format($collectionRate, 2) . '%',
            ];
        }

        $schools = $this->school->pluck('id', 'name')->toArray();
        
        $classBalanceDue = $classTotalFees - $classTotalPaid;
        
        $classCollectionRate = ($classTotalFees > 0) ? ($classTotalPaid / $classTotalFees) * 100 : 0;

        return view('reports.revenue_by_class', compact('startDate', 'endDate', 'schools', 'schoolName', 'reportData', 'classTotalFees', 'classTotalPaid', 'classBalanceDue', 'classCollectionRate'));
    }
}