<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentAccountController extends Controller
{
    
    public function showAccountStatement(int $student)
    {
        $student = Student::findOrFail($student);
        $studentInstallments = $student->installments();
        $studentPayments = $studentInstallments->with('payments')->get();

        
        $grossFees = $student->total_fee ?? 15000.00; 
        $discountAmount = $student->discount ?? 0; 
        

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

        $totalPaidInit = 0;
        
        $totalPaid = array_sum(array_map(function($data) use ($totalPaidInit) {
                return $totalPaidInit += $data['paid_amount'];
            },
            $paymentLog)
        );

        $netFees = $grossFees;
        $balanceDue = $netFees - $totalPaid;

        $register_fees = [
            'amount'         => number_format($student->registrationFees->amount),
            'paid_amount'    => number_format($student->registrationFees->paid_amount),
            'payment_date'   => $student->registrationFees->payment_date,
            'transaction_id' => $student->registrationFees->transaction_id ?? '-',
            'payment_method' => $student->registrationFees->payment_method
        ];

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
            'register_fees' => $register_fees
        ];

        return view('reports.student_fees_report', $reportData);
    }
}