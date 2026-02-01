<x-header title="{{__('app.profile', ['attribute' => __('app.student')]) .' '. $student->full_name }}" />

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>

                    <x-alert type="message" />
                    <x-alert type="error" />

                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-align-top">
                                <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('students.show', $student) }}"><i class="icon-base bx bx-user icon-sm me-1_5"></i>@lang('app.profile', ['attribute' => __('app.student')])</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('student-healthy-history.show', $student) }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i>@lang('app.healthy_history')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('students.installments', $student) }}"><i class="icon-base bx bx-money icon-sm me-1_5"></i>@lang('app.installments')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('students.registrationFees', $student) }}"><i class="icon-base bx bx-money icon-sm me-1_5"></i>@lang('app.registration_fee')</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card mb-6 py-0">
                                <!-- Account -->
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-between align-items-sm-center gap-6 pb-4 border-bottom">
                                        <div class="d-flex align-items-start align-items-sm-center">
                                            <i class="icon-base bx bx-money icon-sm me-1_5 d-block w-px-50 h-px-50 rounded"></i>
                                            <div class="button-wrapper">
                                                <h5>{{ $student->full_name }} - @lang('app.registration_fee')</h5>
                                            </div>
                                        </div>
                                        <a class="btn btn-primary text-white" href="{{ route('students.registrationFees.create', $student) }}">@lang('app.add')</a>
                                    </div>
                                </div>
                                <x-Table.BasicTable>
                                    <x-Table.Thead>
                                        <tr class="text-center">
                                            <th class="align-center">@lang('app.registration_fee')</th>
                                            <th class="align-center">@lang('app.paid_amount')</th>
                                            <th class="align-center">@lang('app.payment_date')</th>
                                            <th class="align-center">@lang('app.payment_method')</th>
                                            @if($registrationFees->transaction_id)
                                            <th class="align-center">@lang('app.process_number')</th>
                                            @endif
                                        </tr>
                                    </x-Table.Thead>
                                    <x-Table.Tbody>
                                        @if($registrationFees)
                                        <tr class="text-center">
                                            <td class="align-center">{{ $registrationFees->amount ?? __('app.not_specified') }}</td>
                                            <td class="align-center">{{ $registrationFees->paid_amount ?? __('app.not_specified') }}</td>
                                            <td class="align-center">{{ $registrationFees->payment_date ?? __('app.not_specified') }}</td>
                                            <td class="align-center">{{ $registrationFees->payment_method ?? __('app.not_specified') }}</td>
                                            @if($registrationFees->transaction_id)
                                                <td class="align-center">{{ $registrationFees->transaction_id ?? __('app.not_specified') }}</td>
                                            @endif
                                        </tr>
                                        @else
                                        <td colspan="5" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.registration_fee')]) }} </td>
                                        @endif
                                    </x-Table.Tbody>
                                </x-Table.BasicTable>
                            </div>
                        </div>
                    </div>
                </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer />
