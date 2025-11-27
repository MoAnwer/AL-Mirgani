<x-header title="{{ __('app.payroll_details') }}" />

<x-layout-wrapper>
    <x-layout-container>
        <x-aside />
        <x-layout-page>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                <x-alert type="message" />
                <x-alert type="error" />
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                
                                <div class="text-center mb-5 card pt-6 pb-3">
                                    <h2 class="display-5 fw-bold text-primary mb-3">{{ __('app.payroll_details') }}</h2>
                                    <p class="lead text-muted fs-5">@lang('app.period'): <span class="fw-bold text-dark">{{ $payroll->month }}/{{ $payroll->year }}</span></p>
                                </div>

                                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                                    
                                    <div class="card-header border-bottom text-white p-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="mb-1 fw-bold">{{ $payroll->employee->full_name ?? __('app.deleted_employee') }}</h4>
                                            </div>
                                            <div>
                                                @if ($payroll->payment_status == \App\Enums\PaymentStatusEnum::PAID->value)
                                                    <span class="badge bg-success-subtle text-success border border-success rounded-pill fs-6 p-2 px-3 "><i class='bx bxs-check-circle me-1'></i> @lang('app.paid')</span>
                                                @elseif ($payroll->payment_status == \App\Enums\PaymentStatusEnum::PENDING->value)
                                                    <span class="badge bg-warning-subtle text-warning border border-warning rounded-pill fs-6 p-2 px-3 "><i class="bx bxs-time me-1"></i>@lang('app.pending')</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill fs-6 p-2 px-3 "><i class='bx bxs-x-circle me-1'></i> @lang('app.failed')</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body p-5">
                                        <div class="row g-5"> 
                                            
                                            <div class="col-md-6 pe-md-4 border-end border-light"> 
                                                <h5 class="text-success border-bottom pb-3 mb-4 fw-bold"><i class='bx bxs-up-arrow-circle me-2'></i>@lang('app.dues')</h5>
                                                <table class="table table-sm table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-muted ps-0">@lang('app.salary')</td>
                                                            <td class="text-end fw-bold text-dark">{{ number_format($payroll->basic_salary_snapshot) }}</td>
                                                        </tr>
                                                        @foreach($additions as $detail)
                                                        <tr>
                                                            <td class="text-muted ps-0">{{ $detail->item->name }}</td>
                                                            <td class="text-end text-success fw-medium">+ {{ number_format($detail->amount) }}</td>
                                                            @if(!$payroll->isPaid())
                                                                
                                                                <td class="text-end ps-0" style="width: 5%;">
                                                                    <a href="{{ route('payroll.details.edit', ['payroll' => $payroll->id, 'detail' => $detail->id]) }}" 
                                                                    class="text-info opacity-75 edit-icon-hover"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('app.edit') }}">
                                                                        <i class='bx bx-edit-alt fs-5'></i>
                                                                    </a>
                                                                </td>
                                                            @endif

                                 
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="border-top mt-4 pt-3"> 
                                                        <tr class="fw-bold fs-5 text-primary">
                                                            <td class="ps-0 pt-3">@lang('app.total_due') </td>
                                                            <td class="text-end pt-3">
                                                                {{ number_format($payroll->basic_salary_snapshot + $payroll->total_fixed_allowances + $payroll->total_variable_additions) }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                            <div class="col-md-6 ps-md-4">
                                                <h5 class="text-danger border-bottom pb-3 mb-4 fw-bold"><i class='bx bxs-down-arrow-circle me-2'></i>@lang('app.deductions')</h5>
                                                <table class="table table-sm table-border-less mb-0">
                                                    <tbody>
                                                        @foreach($deductions as $detail)
                                                        <tr>
                                                            <td class="text-muted ps-0">{{ $detail->item->name }}</td>
                                                            <td class="text-end text-danger fw-medium">({{ number_format($detail->amount) }})</td>
                                                            @if(!$payroll->isPaid())
                                                                <td class="text-end ps-0" style="width: 5%;">
                                                                    <a href="{{ route('payroll.details.edit', ['payroll' => $payroll->id, 'detail' => $detail->id]) }}" 
                                                                    class="text-info opacity-75 edit-icon-hover"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('app.edit') }}">
                                                                        <i class='bx bx-edit-alt fs-5'></i>
                                                                    </a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="border-top mt-4 pt-3"> 
                                                        <tr class="fw-bold fs-5 text-danger">
                                                            <td class="ps-0 pt-3">@lang('app.total_deductions')</td>
                                                            <td class="text-end pt-3">({{ number_format($payroll->total_deductions) }})</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mt-10 p-4 bg-primary bg-gradient-success text-white rounded-3 text-center shadow">
                                            <h4 class="text-uppercase mb-2 fw-normal opacity-75">@lang('app.net_salary_paid')</h4>
                                            <h1 class="fw-bolder mb-0 display-3">{{ number_format($payroll->net_salary_paid) }}</h1>
                                            @if($payroll->payment_date)
                                                <small class="text-white-75 mt-2 d-block fs-6">{{ __('app.payment_date') }}: <span class="fw-bold">{{ $payroll->payment_date->format('Y-m-d') }}</span></small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-footer border-top p-4 d-flex justify-content-start gap-2">
                                        <a href="{{ route('payroll.index') }}" class="btn btn-outline-secondary btn-lg  px-4">
                                            <i class='bx bx-list-ul me-2'></i>@lang('app.back')
                                        </a>


                                        @if (!$payroll->isPaid())
                                        <a href="{{ route('payroll.details.create', $payroll->id) }}" class="btn btn-primary btn-lg  px-4">
                                            <i class='bx bx-plus-circle me-2'></i>@lang('app.add_new_payroll_item')
                                        </a>
                                        <a href="{{ route('payroll.edit', $payroll->id) }}" class="btn btn-warning btn-lg  px-4">
                                            <i class="bx bx-edit me-2"></i> @lang('app.edit_payroll')
                                        </a>
                                        @endif

                                        @if($payroll->isPaid())
                                            <a class="btn btn-primary btn-lg  px-4" href="{{ route('payroll.invoice.print', $payroll) }}"><i class='bx bxs-printer me-1'></i>@lang('app.print')</a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-container>
            </x-content-wrapper>
        </x-layout-page>
    </x-layout-container>
</x-layout-wrapper>
<x-footer/> 

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
    .bg-success-subtle {
        background-color: #d1e7dd !important; 
    }
    .bg-warning-subtle {
        background-color: #fff3cd !important;
    }
    .bg-danger-subtle {
        background-color: #f8d7da !important;
    }
    .text-white-75 { 
        color: rgba(255, 255, 255, 0.75) !important;
    }
    .card {
        border: none !important; 
    }
    .table-borderless td, .table-borderless th {
        border-top: none;
    }
    .table-sm td {
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
    }
    .edit-icon-hover {
        opacity: 0.5;
        transition: opacity 0.2s ease-in-out;
    }
    
    .edit-icon-hover:hover {
        opacity: 1; 
    }
</style>