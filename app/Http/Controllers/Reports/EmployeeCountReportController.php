<?php

namespace App\Http\Controllers\Reports;

use App\Enums\EmployeeTypes;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeCountReportController extends Controller
{
    function __construct(private Employee $employee) {}

    
    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function generateEmployeeCountReport(Request $request)
    {

        $employeeCounts = $this->employee
            ->query()
            ->select('department', DB::raw('COUNT(*) as count'))
            ->groupBy('department')
            ->get();

        [$reportData, $iconMap, $categoryMap] = $this->formatReportData($employeeCounts);

        $grandTotal = $employeeCounts->sum('count');


        return view('reports.employee_count_report', compact('reportData', 'grandTotal', 'categoryMap', 'iconMap'));
    }


    /**
     * Format data to view it
     */
    private function formatReportData($counts)
    {
        $data = [];

        $categoryStyles = [
            EmployeeTypes::TEACHER->value       => ['title' => 'المعلمون', 'icon' => 'bi-person-video', 'bg' => 'primary'],
            EmployeeTypes::MANAGER->value       => ['title' => 'الإداريون', 'icon' => 'bi-briefcase', 'bg' => 'info'],
            EmployeeTypes::WORKER->value        => ['title' => 'العمال', 'icon' => 'bi-tools', 'bg' => 'warning'],
            'other'                             => ['title' => 'أقسام أخرى', 'icon' => 'bi-question-circle', 'bg' => 'secondary'],
        ];

        foreach ($counts as $item) {
            $categoryKey = strtolower($item->department);
            $style = $categoryStyles[$categoryKey] ?? $categoryStyles['other'];

            $data[] = [
                'category_key' => $categoryKey,
                'category_title' => $style['title'],
                'count' => $item->count,
                'style' => $style,
            ];
        }

        $categoryMap = [
            EmployeeTypes::TEACHER->value => 'teacher-color',
            EmployeeTypes::MANAGER->value => 'administrative-color',
            EmployeeTypes::WORKER->value  => 'worker-color',
            'other' => 'other-color',
        ];

        $iconMap = [
            'المعلمون' => 'bxs-user-pin',
            'الإداريون' => 'bxs-briefcase',
            'العمال'  => 'bxs-wrench',
            'أقسام أخرى' => 'bx-question-mark',
        ];

        return [$data, $iconMap, $categoryMap];
    }
}
