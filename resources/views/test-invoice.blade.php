<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قسيمة دفع راتب - {{ $payroll->employee->full_name ?? 'الموظف' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        /* تصميم عصري للـ Payslip */
        .payslip-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .payslip-header {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .payslip-total {
            background-color: #e9ecef; /* لون خلفية ناعم */
            border-radius: 8px;
        }
        /* لتنسيق الجدول بشكل نظيف */
        .table-clean th, .table-clean td {
            border-top: none !important;
            padding-top: 12px;
            padding-bottom: 12px;
        }
        .table-clean th {
            color: #6c757d;
            font-weight: 500;
        }
        /* تنسيقات Print.js مدمجة */
        @media print {
            body {
                background: #fff !important;
            }
            .no-print {
                display: none !important;
            }
            .payslip-container {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body>

    <div class="text-center mt-4 no-print">
        <button onclick="printPayslip()" class="btn btn-primary btn rounded-pill shadow-lg me-3">
            <i class='bx bxs-printer me-2'></i> طباعة قسيمة الدفع
        </button>
        <a href="{{ route('payroll.show', $payroll?->id) }}" class="btn btn-outline-secondary btn rounded-pill">
            <i class='bx bx-arrow-back me-2'></i> العودة للكشف
        </a>
    </div>

<div class="mt-3 payslip-container" id="print-area">
    
    <div class="payslip-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="text-primary fw-bolder mb-2">قسيمة دفع راتب</h1>
            <p class="text-muted mb-0">للفترة المالية: <span class="fw-bold">{{ $payroll?->month }}/{{ $payroll?->year }}</span></p>
        </div>
        <div class="text-end">
            <h4 class="mb-2">{{ config('app.name') ?? 'مؤسسة المبرمجي' }}</h4>
            <small class="text-muted">تاريخ الإصدار: {{ date('Y-m-d') }}</small>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-4">
            <p class="mb-1 text-muted">اسم الموظف:</p>
            <p class="fw-bold fs-5 mb-0">{{ $payroll?->employee->full_name ?? 'موظف محذوف' }}</p>
        </div>
        <div class="col-4 text-end">
            <p class="mb-1 text-muted">حالة الدفع:</p>
            @if ($payroll?->payment_status == 'Paid')
                <span class="badge bg-success-subtle text-success border border-success fs-6 p-2 rounded-pill"><i class='bx bxs-check-circle me-1'></i> مدفوع</span>
            @else
                <span class="badge bg-warning-subtle text-warning border border-warning fs-6 p-2 rounded-pill"><i class='bxs-time me-1'></i> {{ $payroll?->payment_status ?? 'قيد الانتظار' }}</span>
            @endif
        </div>
        <div class="col-4 text-end">
            <p class="mb-0 mt-1 text-muted">تاريخ الدفع: {{ $payroll->payment_date->format('Y-m-d') ?? 'غير محدد' }}</p>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3 fw-bold text-secondary">تفاصيل البنود</h5>
            <table class="table table-clean mb-0">
                <thead>
                    <tr class="border-bottom">
                        <th class="text-center">البند</th>
                        <th class="text-center">النوع</th>
                        <th class="text-center">المبلغ ({{ $currency ?? 'جنيه' }})</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr class="table-light">
                        <td class="text-center fw-bold">الراتب الأساسي</td>
                        <td class="text-center">استحقاق ثابت</td>
                        <td class="text-center fw-bold text-success">{{ number_format($payroll?->basic_salary_snapshot, 2) }}</td>
                    </tr>
                    
                    @foreach($additions as $detail)
                        <tr>
                            <td class="text-center">{{ $detail->item->name ?? 0}}</td>
                            <td class="text-center text-success">إضافة متغيرة</td>
                            <td class="text-center text-success">+ {{ number_format($detail->amount ?? 0, 2) }}</td>
                        </tr>
                    @endforeach


                    @foreach($deductions as $detail)
                        <tr>
                            <td class="text-center">{{ $detail->item->name ?? 0}}</td>
                            <td class="text-center text-danger">استقطاع/ضريبة</td>
                            <td class="text-center text-danger">({{ number_format($detail->amount ?? 0, 2) }})</td>
                        </tr>
                    @endforeach


                    <tr class="border-top">
                        <td colspan="2" class="text-end fw-bold">إجمالي المستحقات (الإجمالي)</td>
                        <td class="text-center fw-bold text-primary">{{ number_format($payroll?->basic_salary_snapshot + $payroll?->total_variable_additions + $payroll?->total_fixed_allowances, 2) }} جنية</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-end fw-bold">إجمالي الاستقطاعات</td>
                        <td class="text-center fw-bold text-danger">({{ number_format($payroll?->total_deductions, 2) }}) جنية</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="payslip-total p-4 text-center">
        <h4 class="text-dark mb-2 fw-normal">صافي المبلغ المستحق الدفع (NET PAY)</h4>
        <h1 class="display-3 fw-bolder text-primary mb-0">{{ number_format($payroll?->net_salary_paid, 2) }} {{ $currency ?? 'جنيه' }}</h1>
    </div>

    <div class="mt-4 pt-3 border-top">
        <p class="small text-muted mb-0">
            * هذا المستند هو قسيمة دفع آلية، ولا يتطلب توقيعاً.
        </p>
    </div>
</div>



<style>

    /* ستايل الطباعة الخاص بالـ Modal */
    @media print {
        /* إخفاء خلفية الـ Modal ورأسه وتذييله */
        body {
            background: #fff !important;
            margin: auto;
        }
        .no-print {
            display: none !important;
        }
        /* هذا الجزء مهم لضمان عرض كامل للتصميم */
        .payslip-container {
            box-shadow: none !important;
            margin: auto !important;
            padding: 0 !important;
            width: 1000px;

        }
    }

    </style>
<script>
    function printPayslip() {
            window.print();
    }
</script>
</body>
</html>