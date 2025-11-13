<x-header title="{{ __('app.student_account_scan') }}"/>

<style>
    
    :root {
        --primary-color: #686BFD; 
        --secondary-color: #f8f9fa; 
        --bg-color: #ffffff; 
        --border-color: #e9ecef; 
        --paid-color: #28a745; 
        --due-color: #dc3545; 
    }
    
    .report-container {
        margin: 20px auto;
        background-color: var(--bg-color);
        border-radius: 12px; 
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); 
        padding: 30px;
    }

    h2, h3 {
        color: #343a40;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 8px;
        margin-bottom: 25px;
        font-weight: 600;
    }
    
    .summary-box, .financial-summary-box {
        background-color: #e6f7ff; 
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-center: 5px solid var(--primary-color);
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 30px;
        border-radius: 8px;
        overflow: hidden;
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
    
    tfoot td {
        background-color: #d1ecf1; 
        font-weight: bold;
        color: #0c5460;
        border-top: 2px solid var(--primary-color);
    }
    
    .balance-due-row td {
        background-color: #f8d7da;
        color: var(--due-color);
        font-weight: bold;
    }
    
    .paid-total-cell {
        background-color: #d4edda !important;
        color: var(--paid-color);
        font-weight: bold;
    }

    .net-fees-cell {
        background-color: #fff3cd;
        font-weight: bold;
    }

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
                    <h2 style="text-align: center;">@lang('app.student_financial_data')</h2>
                    <p style="text-align: center; color: #6c757d; margin-bottom: 40px">@lang('app.date') : {{ now()->format('Y-m-d') }}</p>

                    <div class="summary-box">
                        <h3 style="border-bottom: none; margin-bottom: 10px;">@lang('app.financial_data')</h3>
                        <table style="border-spacing: 5px; margin: 0;">
                            <tr style="background-color: transparent;">
                                <td style="width: 20%; border: none; padding: 5px;"><strong> @lang('app.student_name'):</strong></td>
                                <td style="width: 20%; border: none; padding: 5px;">{{ $student->full_name}}</td>
                                <td style="width: 30%; border: none; padding: 5px;"><strong>@lang('app.class')</strong></td>
                                <td style="width: 20%; border: none; padding: 5px;">{{ __("classes.{$student->stage}") ?? '-' }}</td>
                            </tr>
                            <tr style="background-color: transparent;">
                                <td style="border: none; padding: 5px;"><strong> @lang('app.total_due')</strong></td>
                                <td style="border: none; padding: 5px;">{{ number_format($grossFees , 2) }} {{ __('app.currency')}}</td>
                                <td style="border: none; padding: 5px;"><strong>@lang('app.discount')</strong></td>
                                <td style="border: none; padding: 5px;">{{ $discountAmount }}%</td>
                            </tr>
                            <tr style="background-color: transparent;">
                                <td colspan="3" style="text-align: left; font-size: 1.1em; border: none; padding: 8px;"><strong>@lang('app.net_total_fees'):</strong></td>
                                <td class="net-fees-cell" style="font-size: 1.1em; border: none; text-align: left;"><strong>{{ number_format($netFees , 2) }} {{ __('app.currency')}}</strong></td>
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

                    <h3 stype="">@lang('app.payment_log')</h3>
                    <table>
                        <thead>
                            <tr>
                                <th class="align-center">#</th>
                                <th class="align-center">{{ __('app.payment_date') }}</th>
                                <th class="align-center">@lang('app.receipt_number')</th>
                                <th class="align-center">@lang('app.statement')</th>
                                <th class="align-center">@lang('app.paid_amount')</th>
                                <th class="align-center">@lang('app.payment_method')</th>
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
                                <td class="align-center">{{ $payment['payment_method'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #6c757d;">@lang('app.no_payment_log')</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="1" style="text-align: left;">@lang('app.total_paid_amount_collected')</td>
                                <td colspan="6" class="paid-total-cell align-center">{{ number_format($totalPaid , 2) }} {{ __('app.currency')}}</td>
                            </tr>
                        </tfoot>
                    </table>


                    <h3>@lang('app.financial_summary')</h3>
                    <table>
                        <tr>
                            <td style="width: 40%;">@lang('app.net_total_due_fee')</td>
                            <td style="width: 60%;">{{ number_format($netFees , 2) }} {{ __('app.currency')}}</td>
                        </tr>
                        <tr>
                            <td>@lang('app.total_paid_amount')</td>
                            <td>{{ number_format($totalPaid , 2) }} {{ __('app.currency')}}</td>
                        </tr>
                        <tr class="{{ 1 > 0 ? 'balance-due' : '' }}">
                            <td><strong>@lang('app.student_remaining_amount')</strong></td>
                            <td><strong>{{ number_format($balanceDue , 2) }} {{ __('app.currency')}}</strong></td>
                        </tr>
                    </table>

                    <h3 style="margin-top: 30px;">@lang('app.installment_scheduler')</h3>
                    <table>
                        <thead>
                            <tr>
                                <th class="align-center">@lang('app.the_installment')</th>
                                <th class="align-center">@lang('app.due_date')</th>
                                <th class="align-center">@lang('app.due_amount')</th>
                                <th class="align-center">@lang('app.paid_amount')</th>
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
                                <td colspan="4" style="text-align: center; color: #6c757d;">@lang('app.empty_message', ['attributes' => __('app.installments')])</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />