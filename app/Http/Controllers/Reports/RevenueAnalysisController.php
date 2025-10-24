<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom; // نموذج الصفوف/المراحل
use App\Models\School;
use App\Models\Student;

class RevenueAnalysisController extends Controller
{
    public function revenueBySchool(int $school_id)
    {
        // 1. جلب جميع الصفوف المدرسية
        $classes = ClassRoom::all();
        $schoolName = School::findOrFail($school_id)->name;
        $reportData = [];
        
        $classTotalFees = 0;
        $classTotalPaid = 0;
        $classTotalDiscount = 0;

        foreach ($classes as $class) {

            // جلب طلاب الصف مع سجلات الإيرادات
            $students = Student::where('class_id', $class->id)->where('school_id', $school_id)->get();
            
            // 2. حساب الإجماليات للصف الواحد
            $studentCount = $students->count();
            
            // إذا كان لديك حقول total_fees و discount_amount في جدول الطالب:
            $grossFees = $students->sum('total_fee');
            $discountAmount = $students->sum('discount');

            $netFees = $grossFees;
            
            // جلب الإيرادات المحصلة من كل طالب في هذا الصف
            $totalPaid = $students->sum(function ($student) {
                return $student->totalPaid();
            });

            // 3. حساب الأرصدة والنسب
            $balanceDue = $netFees - $totalPaid;
            $collectionRate = ($netFees > 0) ? ($totalPaid / $netFees) * 100 : 0;
            
            // 4. تجميع الإجماليات الكلية
            $classTotalFees += $netFees;
            $classTotalPaid += $totalPaid;

            // 5. بناء مصفوفة التقرير
            $reportData[] = [
                'class_name' => $class->name,
                'student_count' => $studentCount,
                'net_fees' => $netFees,
                'total_paid' => $totalPaid,
                'balance_due' => $balanceDue,
                'collection_rate' => number_format($collectionRate, 2) . '%',
            ];
        }
        
        // حساب إجمالي نسبة التحصيل للمدرسة
        $classBalanceDue = $classTotalFees - $classTotalPaid;
        $classCollectionRate = ($classTotalFees > 0) ? ($classTotalPaid / $classTotalFees) * 100 : 0;

        return view('reports.revenue_by_class', compact('schoolName', 'reportData', 'classTotalFees', 'classTotalPaid', 'classBalanceDue', 'classCollectionRate'));
    }
}