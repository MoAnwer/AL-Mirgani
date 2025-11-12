<x-header title="{{ __('app.receipt') .' / '. $receipt->number }}"/>

<style>
        body { background-color: #f8f9fa; }
        .receipt-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .header-section {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .amount-box {
            background-color: #d1e7dd; /* Success subtle background */
            color: #0f5132; /* Success text color */
            border-radius: 8px;
            font-size: 1.8rem;
        }
        .table-info th, .table-info td {
            border-top: none;
            padding: 8px 0;
        }
        
        @media print {
            body {
                background-color: #fff !important;
            }
            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                max-width: 100% !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

    <x-alert type="message"/>

<div class="receipt-container" id="receipt-print-area">
    
    <div class="header-section d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-primary fw-bolder mb-2">@lang('app.receipt')</h3>
            <p class="text-muted mb-0"> @lang('app.receipt_number') : <span class="fw-bold">{{ $receipt->number }}</span></p>
        </div>
        <div class="text-end">
            <h5 class="mb-1">{{ config('app.name') }}</h5>
            <small class="text-muted fw-bold">@lang('app.date'): {{ $receipt->created_at->format('Y-m-d') }}</small>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h6 class="fw-bold text-secondary mb-3">@lang('app.payment_details')</h6>
            <table class="table">
                <tbody>
                    <tr>
                        <th class="px-2" style="width: 30%;">@lang('app.student_name')</th>
                        <td>{{ $receipt->student->full_name ?? __('app.deleted_student') }}</td>
                    </tr>
                    <tr>
                        <th class="px-2">@lang('app.class')</th>
                        <td>{{ $receipt->student->class->name ?? '--' }}</td>
                    </tr>
                    <tr>
                        <th class="px-2">@lang('app.installment')</th>
                        <td>{{ $receipt->installmentPayment->installment->number ?? '' }}</td>
                    </tr>
                    <tr>
                        <th class="px-2">@lang('app.payment_method')</th>
                        <td>{{ $receipt->installmentPayment->payment_method ?? __('app.cash') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        
        <div class="col-md-6">
            <div class="card amount-box p-3 text-center shadow-none border border-success">
                <p class="mb-1 fw-bold">@lang('app.paid_amount')</p>
                <h4 class="fw-bolder mb-0">{{ number_format($receipt->amount, 2) }} {{ __('app.currency')}}</h4>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card p-3 py-5 text-center border border-secondary shadow-none">
                <p class="mb-1 fw-bold text-muted">@lang('app.remaining')</p>
                <h4 class="fw-bolder mb-0 text-dark">{{ number_format($receipt->remanent ?? 0, 2) }} {{ __('app.currency')}}</h4>
            </div>
        </div>
    </div>

    <div class="mt-4 pt-3 border-top">
        <p class="small text-muted mb-10">
        </p>
        <div class="d-flex justify-content-between">
            <div class="text-center mt-5">
                <p class="mb-0 fw-bold pt-4 px-10 border-top border-dark pt-1">@lang('app.receiver_signature')</p>
            </div>
            <div class="text-center mt-5">
                <p class="mb-0 fw-bold pt-4 px-10 border-top border-dark pt-1">@lang('app.employee_signature')</p>
            </div>
        </div>
    </div>
</div>

<div class="text-center my-4 no-print">
    <button onclick="window.print()" class="btn btn-primary btn-lg rounded-pill shadow-lg me-3">
        <i class='bx bxs-printer me-2'></i>  @lang('app.print')
    </button>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg rounded-pill">
        <i class='bx bx-arrow-back me-2'></i>@lang('app.back')
    </a>
</div>

</body>
</html>