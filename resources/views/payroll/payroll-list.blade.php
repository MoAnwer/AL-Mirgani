<x-header title="{{ __('app.payrolls_list') }}" />

<x-layout-wrapper>
    <x-layout-container>
        <x-aside />
        <x-layout-page>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                    <h3 class="mb-10">{{ __('app.payrolls_list') }}</h3>
                    <x-alert type="message" />
                    <x-alert type="error" />
                    <div class="card shadow mb-4">
                        <div class="card-header border-bottom py-4">
                            <h5 class="mb-0">{{ __('app.filters') }}</h5>
                        </div>
                        <div class="card-body mt-5">
                            <form method="GET" action="{{ route('payroll.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label for="employee_id" class="form-label pb-1">{{ __('app.employee') }}</label>
                                        <select name="employee_id" onchange="this.form.submit()" id="employee_id" class="form-select">
                                            <option value="">----</option>
                                            @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->full_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="payment_status" class="form-label  pb-1">{{ __('app.payment_state') }}</label>
                                        <select name="payment_status" onchange="this.form.submit()" id="payment_status" class="form-select">
                                            <option value="{{ null }}">---</option>
                                            <option value="Paid" @selected(request('payment_status')=='Paid' )>@lang('app.paid')</option>
                                            <option value="Pending" @selected(request('payment_status')=='Pending' )>@lang('app.pending')</option>
                                            <option value="Failed" @selected(request('payment_status')=='Failed' )>@lang('app.failed')</option>
                                        </select>
                                    </div>
                                     <div class="col-2">
                                            <label class="form-label text-dark fw-medium pb-1">@lang('app.payment_method')</label>
                                            <select class="form-select" name="payment_method" onchange="this.form.submit()">
                                                <option value="{{ null }}" selected>----</option>
                                                    @foreach(['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')] as $key => $value)
                                                <option value="{{ $key }}" @selected(request()->query('payment_method') == $key)>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="month" class="form-label  pb-1">{{ __('app.the_month') }}</label>
                                        <input type="number" onchange="this.form.submit()" name="month" id="month" class="form-control" value="{{ request('month') }}" min="1" max="12">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="year" class="form-label  pb-1">{{ __('app.year') }}</label>
                                        <input type="number" onchange="this.form.submit()" name="year" id="year" class="form-control" value="{{ request('year') }}">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-body p-0">
                            <x-table.basic-table>
                                <x-table.thead>
                                    <tr class="text-center">
                                        <td>#</td>
                                        <td>@lang('app.employee')</td>
                                        <td>@lang('app.period')</td>
                                        <td>@lang('app.basic_salary')</td>
                                        <td>@lang('app.total_due')</td>
                                        <td>@lang('app.total_deductions')</td>
                                        <td>@lang('app.total_paid_amount')</td>
                                        <td>@lang('app.payment_state')</td>
                                        <td>@lang('app.payment_method')</td>
                                        <td>@lang('app.process_number')</td>
                                        <td>@lang('app.payment_date')</td>
                                        <td>@lang('app.actions')</td>
                                    </tr>
                                </x-table.thead>
                                <x-table.tbody>
                                    @forelse ($payrolls as $payroll)
                                    <tr class="text-center">
                                        <td>{{ $payroll->id }}</td>
                                        <td class="text-start fw-bold">{{ $payroll->employee->full_name ?? __('app.deleted_employee') }}</td>
                                        <td>{{ $payroll->month }}/{{ $payroll->year }}</td>
                                        <td>{{ number_format($payroll->basic_salary_snapshot) }} {{ __('app.currency')}}</td>
                                        <td>
                                            {{ number_format($payroll->basic_salary_snapshot + $payroll->total_fixed_allowances + $payroll->total_variable_additions) }} {{ __('app.currency')}}
                                        </td>
                                        <td class="text-danger">({{ number_format($payroll->total_deductions) }} {{ __('app.currency')}}) </td>
                                        <td class="fw-bolder text-primary">{{ number_format($payroll->net_salary_paid) }} {{ __('app.currency')}}</td>
                                        <td>
                                            @if ($payroll->isPaid())
                                            <span class="badge bg-success-subtle text-success border border-success rounded">
                                                <i class="bx bxs-check-circle"></i>
                                                @lang('app.paid')
                                            </span>
                                            @elseif ($payroll->isPending())
                                            <span class="badge bg-warning-subtle text-warning border border-warning rounded">
                                                <i class="bx bxs-time"></i>
                                                @lang('app.pending')
                                            </span>
                                            @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger rounded"> <i class='bx bxs-x-circle me-1'></i>@lang('app.failed')</span>
                                            @endif
                                        </td>
                                        <td>{{ ($payroll->payment_method == 'كاش' ? __('app.cash') : __('app.bankak'))   ?? __('app.cash') }}</td>
                                        <td>{{ $payroll->transaction_id ?? '' }}</td>
                                        <td>
                                            @if ($payroll->payment_date)
                                            {{ $payroll->payment_date->format('Y-m-d') }}
                                            @endif
                                        </td>
                                        @if($payroll->employee)
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('payroll.show', $payroll->id) }}" class="btn btn-sm btn-info">
                                                        <i class='bx bx-news me-1 text-info'></i>
                                                        @lang('app.view')
                                                    </a>
                                                    @if ($payroll->isPending())
                                                    <a class="dropdown-item" href="{{ route('payroll.edit', $payroll->id) }}" class="btn btn-sm btn-warning me-1"> <i class='bx bxs-edit-alt me-1 text-success'></i>@lang('app.edit')</a>
                                                    <a class="dropdown-item" href="{{ route('payroll.delete', $payroll) }}" class="btn btn-sm btn-warning me-1"> <i class='bx bxs-trash me-1 text-danger'></i>@lang('app.delete')</a>
                                                    @endif
                                                    @if($payroll->isPaid())
                                                    <a class="dropdown-item" href="{{ route('payroll.invoice.print', $payroll) }}" class="btn btn-sm btn-warning me-1"><i class='bx bxs-printer me-1 text-primary'></i> @lang('app.print')</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-muted py-4">
                                            @lang('app.no_date_returned')
                                        </td>
                                    </tr>
                                    @endforelse
                                </x-table.tbody>
                                <tfoot class="bg-label-secondary text-light">
                                    <tr class="text-light text-center fw-bold">
                                        <td></td>
                                        <td class="text-center" colspan="2">@lang('app.total')</td>
                                        <td>{{ number_format($payrolls->sum('basic_salary_snapshot')) }} {{ __('app.currency')}}</td>
                                        <td>{{ number_format(
                                                    $payrolls->sum('basic_salary_snapshot') + 
                                                    $payrolls->sum('total_fixed_allowances') +
                                                    $payrolls->sum('total_variable_additions')
                                                    ) }} {{ __('app.currency')}}</td>
                                        <td>{{ number_format($payrolls->sum('total_deductions')) }} {{ __('app.currency')}}</td>
                                        <td>{{ number_format($payrolls->sum('net_salary_paid')) }} {{ __('app.currency')}}</td>
                                        <td colspan="5"></td>
                                    </tr>
                                </tfoot>
                            </x-table.basic-table>
                        </div>
                        <div class="card-footer mt-5">
                            {{ $payrolls->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </x-container>
            </x-content-wrapper>
        </x-layout-page>
    </x-layout-container>
</x-layout-wrapper>
<x-footer />
