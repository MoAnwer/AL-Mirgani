<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentAccountController extends Controller
{
    /**
     * يعرض كشف حساب تحصيل الرسوم لطالب محدد.
     */
    public function showAccountStatement(int $student)
    {
        // 1. جلب بيانات الطالب الأساسية
        $student = Student::findOrFail($student);
        $studentInstallments = $student->installments();
        $studentPayments = $studentInstallments->with('payments')->get();

        
        // **هنا يجب تعديل الحقول لتناسب نموذج الطالب الخاص بك**
        $grossFees = $student->total_fee ?? 15000.00; // افتراض مبلغ
        $discountAmount = $student->discount; // افتراض خصم
        

        // 3. تجهيز سجل الدفعات التفصيلي
        // نحتاج إلى ترتيب سجلات الإيرادات حسب تاريخ الدفع
        $paymentLog = [];
        $data = [];

        foreach ($studentPayments->all() as $installment) {
            $data[] = $installment->payments->map(function ($payment) {
                return [
                    'payment_date' => $payment->payment_date ?? 0,
                    'receipt_number' => $payment->receipt_number ?? 0,
                    'statement' => $payment->notes ?? '',
                    'paid_amount' => $payment->paid_amount ?? 0,
                    'payment_method' => $payment->payment_method ?? '',
                    'collector' => $payment->collector->name ?? 'موظف مالي', // إذا كان لديك علاقة مع موظف
                ];
            });
        }

        foreach ($data as $payments) {
            foreach ($payments as $data) {
                $paymentLog[] = $data;
            }
        }

        array_multisort($paymentLog);

        // 2. حساب الملخص المالي
        $totalPaidInit = 0;
        
        $totalPaid = array_sum(array_map(function($data) use ($totalPaidInit) {
                return $totalPaidInit += $data['paid_amount'];
            },
            $paymentLog)
        );

        $netFees = $grossFees;
        $balanceDue = $netFees - $totalPaid;


        // 4. تجهيز جدول الأقساط (نحتاج لجدول installments حقيقي لتحديد التواريخ)
        // لتبسيط المثال، سنقوم بإنشاء بيانات وهمية
        $installmentsSchedule = $student->installments->sortBy('date')->map(function($installment)  {
            return  [
                'number'    => $installment->number ?? 0,
                'due_date'  => date('Y-m-d', strtotime($installment->due_date)), 
                'amount'    => $installment->amount ?? 0,
                'status'    => $installment->payments?->sum('paid_amount') ?? 0,
            ];
        });

        $reportData = [
            'student' => $student,
            'grossFees' => $grossFees,
            'discountAmount' => $discountAmount,
            'netFees' => $netFees,
            'totalPaid' => $totalPaid,
            'balanceDue' => $balanceDue,
            'paymentLog' => $paymentLog,
            'installmentsSchedule' => $installmentsSchedule,
        ];

        return view('reports.student_fees_report', $reportData);
    }
}