<x-header title=" {{ __('app.payroll_invoice') .' - '.$payroll->employee->full_name ?? __('app.employee') }}" />


    <style>
        body {
            background-color: #f8f9fa;
        }
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
            background-color: #e9ecef; 
            border-radius: 8px;
        }

        .table-clean th, .table-clean td {
            border-top: none !important;
            padding-top: 12px;
            padding-bottom: 12px;
        }
        .table-clean th {
            color: #6c757d;
            font-weight: 500;
        }
        
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

    <div class="text-center mt-4 no-print">
        <button onclick="printPayslip()" class="btn btn-primary btn rounded-pill shadow-lg me-3">
            <i class='bx bxs-printer me-2'></i>@lang('app.print')  
        </button>
        <a href="{{ route('payroll.show', $payroll?->id) }}" class="btn btn-outline-secondary btn rounded-pill">
            <i class='bx bx-arrow-back me-2'></i>@lang('app.back') 
        </a>
    </div>

<div class="mt-3 payslip-container" id="print-area">
    
    <div class="payslip-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="text-primary fw-bolder mb-2">@lang('app.payroll_invoice')</h1>
            <p class="text-muted mb-0">@lang('app.period'): <span class="fw-bold">{{ $payroll?->month }}/{{ $payroll?->year }}</span></p>
        </div>
        <div class="text-end">
            <h4 class="mb-2">{{ config('app.name') ?? '-'}}</h4>
            <small class="text-muted"> @lang('app.payroll_invoice_date'): {{ date('Y-m-d') }}</small>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-4">
            <p class="mb-1 text-muted">@lang('app.employee_name'): </p>
            <p class="fw-bold fs-5 mb-0">{{ $payroll?->employee->full_name ?? __('app.deleted_employee') }}</p>
        </div>
        <div class="col-4 text-end">
            <p class="mb-1 text-muted">@lang('app.payment_state')</p>
            @if ($payroll?->payment_status == 'Paid')
                <span class="badge bg-success-subtle text-success border border-success fs-6 p-2 rounded-pill"><i class='bx bxs-check-circle me-1'></i>@lang('app.paid')</span>
            @else
                <span class="badge bg-warning-subtle text-warning border border-warning fs-6 p-2 rounded-pill"><i class='bxs-time me-1'></i> {{ $payroll?->payment_status ?? __('app.pending') }}</span>
            @endif
        </div>
        <div class="col-4 text-end">
            <p class="mb-0 mt-1 text-muted">@lang('app.payment_date'): {{ $payroll->payment_date->format('Y-m-d') ?? '-' }}</p>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3 fw-bold text-secondary">@lang('app.invoice_details')</h5>
            <table class="table table-clean mb-0">
                <thead>
                    <tr class="border-bottom">
                        <th class="text-center">@lang('app.item')</th>
                        <th class="text-center">@lang('app.category')</th>
                        <th class="text-center">@lang('app.amount')({{ $currency ?? 'SDG' }})</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr class="table-light">
                        <td class="text-center fw-bold">@lang('app.basic_salary')</td>
                        <td class="text-center">@lang('app.fixed_due')</td>
                        <td class="text-center fw-bold text-success">{{ number_format($payroll?->basic_salary_snapshot) }}</td>
                    </tr>
                    
                    @foreach($additions as $detail)
                        <tr>
                            <td class="text-center">{{ $detail->item->name ?? 0}}</td>
                            <td class="text-center text-success">@lang('app.variable_addition')</td>
                            <td class="text-center text-success">+ {{ number_format($detail->amount ?? 0) }}</td>
                        </tr>
                    @endforeach


                    @foreach($deductions as $detail)
                        <tr>
                            <td  class="text-center">{{ $detail->item->name ?? 0}}</td>
                            <td  class="text-center text-danger">@lang('app.deduction')</td>
                            <td  class="text-center text-danger">-{{ number_format($detail->amount ?? 0) }}</td>
                        </tr>
                    @endforeach


                    <tr class="border-top">
                        <td colspan="2" class="text fw-bold">@lang('app.total_due')</td>
                        <td class="text-center fw-bold text-primary">{{ number_format($payroll?->basic_salary_snapshot + $payroll?->total_variable_additions + $payroll?->total_fixed_allowances) }} SDG</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text fw-bold">@lang('app.total_deductions')</td>
                        <td class="text-center fw-bold text-danger">{{ number_format($payroll?->total_deductions) }} SDG</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="payslip-total p-4 text-center">
        <h4 class="text-dark mb-2 fw-normal">@lang('app.net_salary_paid')</h4>
        <h1 class="display-3 fw-bolder text-primary mb-0">{{ number_format($payroll?->net_salary_paid) }} {{ $currency ?? 'SDG' }}</h1>
    </div>
</div>



<style>

    @media print {
        body {
            background: #fff !important;
            margin: auto;
        }
        .no-print {
            display: none !important;
        }
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