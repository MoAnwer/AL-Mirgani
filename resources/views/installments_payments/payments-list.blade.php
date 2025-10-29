<x-header title="{{ __('app.installment_payments'). ' ' . $installment->number . ' ' . $installment->student->full_name}}" />

<x-layout-wrapper >
    <x-layout-container>
        <x-aside />
            <x-layout-page>
                <x-nav/>
                <x-content-wrapper>
                    <x-container>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="nav-align-top">
                                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('students.show', $installment->student) }}"
                                            ><i class="icon-base bx bx-user icon-sm me-1_5"></i>@lang('app.profile', ['attribute' => __('app.student')])</a
                                            >
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('student-healthy-history.show', $installment->student) }}"
                                            ><i class="icon-base bx bx-bell icon-sm me-1_5"></i>@lang('app.healthy_history')</a
                                            >
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('students.installments', $installment->student) }}"
                                            ><i class="icon-base bx bx-money icon-sm me-1_5"></i>@lang('app.installments')</a
                                            >
                                        </li>
                                    </ul>
                                </div>
                                <div class="card mb-6 py-0">
                                    <x-alert type="message" /> 
                                    <x-alert type="error" /> 
                                        <!-- Account -->
                                    <div class="card-body pb-0">
                                        <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4">
                                            <i class="icon-base bx bx-money icon-sm me-1_5 d-block w-px-100 h-px-100 rounded"></i>
                                            <div class="button-wrapper">
                                                <h5>@lang('app.installment_payments') {{ $installment->number .' - '. $installment->student->full_name}} </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-sm-center gap-6 pb-4">
                                            <div class="d-flex align-items-start align-items-sm-center">
                                                <div class="button-wrapper">
                                                </div>
                                            </div>
                                            <a class="btn btn-primary text-white" href="{{ route('installments.payments.create', $installment->id) }}">@lang('app.create', ['attribute' => __('app.payment')])</a>
                                        </div>
                                        </div>
                                        <x-Table.BasicTable>
                                            <x-Table.Thead>
                                                <tr class="text-center">
                                                    <th>#</th>
                                                    <th>@lang('app.paid_amount')</th>
                                                    <th>@lang('app.payment_method')</th>
                                                    <th>@lang('app.receipt_number')</th>
                                                    <th>@lang('app.payment_date')</th>
                                                    <th>@lang('app.statement')</th>
                                                    <th>@lang('app.actions')</th>
                                                </tr>
                                            </x-Table.Thead>
                                            <x-Table.Tbody>
                                                @forelse($installment->payments as $payment)
                                                    <tr class="text-center">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ number_format($payment->paid_amount, 0) }} جنية</td>
                                                        <td>{{ $payment->payment_method }}</td>
                                                        <td>{{ $payment->receipt_number ?? 'لا يوجد بعد' }}</td>
                                                        <td>{{ $payment->payment_date }}</td>
                                                        <td>{{ $payment->statement }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                    <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    @if(!$payment->receipt_number)
                                                                        <form method="post" action="{{ route('receipts.store', $payment) }}">
                                                                            @csrf
                                                                            @method('post')
                                                                            <button class="dropdown-item"><i class="bx bx-news me-1"></i>استخراج ايصال</button>
                                                                        </form>
                                                                    @endif
                                                                    <a class="dropdown-item" href="{{ route('installments.payments.edit', $payment) }}"><i class="icon-base bx bx-edit-alt me-1"></i>@lang('app.edit')</a>
                                                                    <a class="dropdown-item" href="{{ route('installments.payments.delete', $payment) }}"><i class="icon-base bx bx-trash me-1"></i>@lang('app.delete')</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <td colspan="7" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.installment_payments')]) }} </td>
                                                @endforelse
                                                <tfoot class="bg-label-secondary">
                                                    <tr class="fw-bold">
                                                        <td colspan="6">@lang('app.total_payment')</td>
                                                        <td>{{ number_format($installment->total_payments, 0) }} جنية</td>
                                                    </tr>
                                                    <tr class="fw-bold">
                                                        <td colspan="6">@lang('app.remaining')</td>
                                                        <td>{{ number_format($installment->remaining, 0) }} جنية</td>
                                                    </tr>
                                                </tfoot>
                                            </x-Table.Tbody>
                                        </x-Table.BasicTable>    
                                    </div>
                                </div>
                            </div>
                    </x-container>
                </x-content-wrapper>
            </x-layout-page>
    </x-layout-container>                                                           
</x-layout-wrapper>
<x-footer />