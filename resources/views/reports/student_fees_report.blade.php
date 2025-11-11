<x-header title="{{ __('app.student_account_scan') }}"/>

<style>
    
    /* Modern, Flat, and Calm CSS Styles */
    :root {
        --primary-color: #686BFD; /* أزرق أساسي هادئ */
        --secondary-color: #f8f9fa; /* خلفية الجداول والبنود */
        --bg-color: #ffffff; /* خلفية الجسم */
        --border-color: #e9ecef; /* لون الحدود الخفيف */
        --paid-color: #28a745; /* أخضر للدفعات */
        --due-color: #dc3545; /* أحمر خفيف للمستحق */
    }
    
    .report-container {
        margin: 20px auto;
        background-color: var(--bg-color);
        border-radius: 12px; /* حواف مستديرة */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* ظل ناعم */
        padding: 30px;
    }

    h2, h3 {
        color: #343a40;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 8px;
        margin-bottom: 25px;
        font-weight: 600;
    }
    
    /* Box Styles */
    .summary-box, .financial-summary-box {
        background-color: #e6f7ff; /* خلفية زرقاء فاتحة جدًا */
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-center: 5px solid var(--primary-color);
    }

    /* Table Styles */
    table {
        width: 100%;
        border-collapse: separate; /* لإضافة حواف مستديرة */
        border-spacing: 0;
        margin-bottom: 30px;
        border-radius: 8px;
        overflow: hidden; /* لاخفاء الحواف الزائدة */
    }
    
    th, td {
        padding: 12px 15px;
        text-align: right;
        border-bottom: 1px solid var(--border-color);
    }
    
    th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        text-align: right;
    }
    
    tr:nth-child(even) {
        background-color: var(--secondary-color);
    }
    
    /* Footer/Totals Styling */
    tfoot td {
        background-color: #d1ecf1; /* لون مميز للإجمالي */
        font-weight: bold;
        color: #0c5460;
        border-top: 2px solid var(--primary-color);
    }
    
    /* Status/Balance Styling */
    .balance-due-row td {
        background-color: #f8d7da; /* خلفية وردية خفيفة */
        color: var(--due-color);
        font-weight: bold;
    }
    
    .paid-total-cell {
        background-color: #d4edda !important;
        color: var(--paid-color);
        font-weight: bold;
    }

    .net-fees-cell {
        background-color: #fff3cd; /* لون اصفر هادئ لصافي الرسوم */
        font-weight: bold;
    }

    /* Adjusting text alignment for amounts */
    .align-center { text-align: left; }
    .align-center { text-align: center; }
</style>

<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="report-container">
                    <h2 style="text-align: center;">كشف تحصيل الرسوم للطالب</h2>
                    <p style="text-align: center; color: #6c757d; margin-bottom: 40px">تاريخ التقرير: {{ now()->format('Y-m-d') }}</p>

                    <div class="summary-box">
                        <h3 style="border-bottom: none; margin-bottom: 10px;">بيانات الالتزام المالي</h3>
                        <table style="border-spacing: 5px; margin: 0;">
                            <tr style="background-color: transparent;">
                                <td style="width: 20%; border: none; padding: 5px;"><strong>اسم الطالب:</strong></td>
                                <td style="width: 20%; border: none; padding: 5px;">{{ $student->full_name}}</td>
                                <td style="width: 30%; border: none; padding: 5px;"><strong>الصف/المرحلة:</strong></td>
                                <td style="width: 20%; border: none; padding: 5px;">{{ $student->stage ?? 'غير محدد' }}</td>
                            </tr>
                            <tr style="background-color: transparent;">
                                <td style="border: none; padding: 5px;"><strong>المستحقات الكلية:</strong></td>
                                <td style="border: none; padding: 5px;">{{ number_format($grossFees , 2) }} جنية</td>
                                <td style="border: none; padding: 5px;"><strong>الخصومات/الإعفاءات:</strong></td>
                                <td style="border: none; padding: 5px;">{{ $discountAmount }}%</td>
                            </tr>
                            <tr style="background-color: transparent;">
                                <td colspan="3" style="text-align: left; font-size: 1.1em; border: none; padding: 8px;"><strong>صافي الرسوم المستحقة الكلية:</strong></td>
                                <td class="net-fees-cell" style="font-size: 1.1em; border: none; text-align: left;"><strong>{{ number_format($netFees , 2) }} جنية</strong></td>
                            </tr>
                        </table>
                    </div>


                    <h3>@lang('app.registration_fee')</h3>
                    <table>
                        <thead>
                            <tr>
                                <th class="align-center">@lang('app.registration_fee')</th>
                                <th class="align-center">@lang('app.paid_amount')</th>
                                <th class="align-center">@lang('app.payment_date')</th>
                                <th class="align-center">@lang('app.payment_method')</th>
                                <th class="align-center">@lang('app.process_number')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-center">{{ $register_fees['amount'] }}</td>
                                <td class="align-center">{{ $register_fees['paid_amount'] }}</td>
                                <td class="align-center">{{ $register_fees['payment_date'] }}</td>
                                <td class="align-center">{{ $register_fees['payment_method'] }}</td>
                                <td class="align-center">{{ $register_fees['transaction_id'] }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3 stype="">سجل الدفعات (التحصيل)</h3>
                    <table>
                        <thead>
                            <tr>
                                <th class="align-center">#</th>
                                <th class="align-center">{{ __('app.payment_date') }}payment_date') }}payment_date') }}payment_date') }}ة</th>
                                <th class="align-center">رقم الإيصال</th>
                                <th class="align-center">بيان الحركة</th>
                                <th class="align-center">مبلغ الدفعة</th>
                                <th class="align-center">طريقة الدفع</th>
                                <th class="align-center">الموظف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paymentLog as $payment)
                            <tr>
                                <td class="align-center">{{ $loop->iteration }}</td>
                                <td class="align-center">{{ $payment['payment_date']  }}</td>
                                <td class="align-center">{{ $payment['receipt_number'] ??0 }}</td>
                                <td class="align-center">{{ $payment['statement'] }}</td>
                                <td class="align-center" class="align-center">{{ number_format($payment['paid_amount'] ?? 0, 2) }}</td>
                                <td class="align-center">{{ $payment['payment_method']}}</td>
                                <td class="align-center">{{ $payment['collector'] ??0}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #6c757d;">لم يتم تسجيل أي دفعات لهذا الطالب بعد.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="1" style="text-align: left;">الإجمالي المحصّل حتى تاريخه:</td>
                                <td colspan="6" class="paid-total-cell align-center">{{ number_format($totalPaid , 2) }} جنية</td>
                            </tr>
                        </tfoot>
                    </table>


                    <h3>ملخص الموقف المالي</h3>
                    <table>
                        <tr>
                            <td style="width: 40%;">صافي الرسوم المستحقة</td>
                            <td style="width: 60%;">{{ number_format($netFees , 2) }} جنية</td>
                        </tr>
                        <tr>
                            <td>إجمالي المبلغ المدفوع</td>
                            <td>{{ number_format($totalPaid , 2) }} جنية</td>
                        </tr>
                        <tr class="{{ 1 > 0 ? 'balance-due' : '' }}">
                            <td><strong>المبلغ المتبقي على الطالب</strong></td>
                            <td><strong>{{ number_format($balanceDue , 2) }} جنية</strong></td>
                        </tr>
                    </table>

                    <h3 style="margin-top: 30px;">جدول الأقساط وتواريخ الاستحقاق المتبقية</h3>
                    <table>
                        <thead>
                            <tr>
                                <th class="align-center">القسط</th>
                                <th class="align-center">تاريخ الاستحقاق</th>
                                <th class="align-center">المبلغ المتوقع</th>
                                <th class="align-center">الحالة الحالية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($installmentsSchedule as $installment)
                            <tr>
                                <td class="text-center">{{ $installment['number'] }}</td>
                                <td class="text-center">{{ $installment['due_date'] }}</td>
                                <td class="text-center" class="align-center">{{ number_format($installment['amount'] ??  0, 2) }}</td>
                                <td class="text-center">{{ number_format($installment['status'] ) }}</td>
                            </tr>
                            @empty
                                <td colspan="4" style="text-align: center; color: #6c757d;">لم يتم تسجيل أي اقساط لهذا الطالب بعد.</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />