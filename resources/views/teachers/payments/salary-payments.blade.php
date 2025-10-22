    <div class="col">
        <div class="card py-0">
                <div class="card-body pb-0">
                <div class="d-flex justify-content-between align-items-sm-center gap-6 pb-4 border-bottom">
                    <div class="d-flex align-items-start align-items-sm-center">
                        <i class="icon-base bx bx-money icon-sm me-1_5 d-block w-px-50 h-px-50 rounded"></i>
                        <div class="button-wrapper">
                        <h5>
                            @lang('app.list', ['attribute' => __('app.salary_payments')])
                        </h5>
                    </div>
                </div>
                    <a class="btn btn-primary text-white" href="{{ route('teacher.salary-payment.create', $teacher) }}">
                        @lang('app.create', ['attribute' => __('app.payment')])
                    </a>
                </div>
            </div>
        <x-Table.BasicTable>
            <x-Table.Thead>
                <th>#</th>
                <th>@lang('app.amount')</th>
                <th>@lang('app.the_month')</th>
                <th>@lang('app.remaining')</th>
                <th>@lang('app.payment_date')</th>
                <th>@lang('app.signature_state')</th>
            </x-Table.Thead>
            <x-Table.Tbody>
                @forelse($teacher->salaryPayments()->latest()->paginate(5) as $salary)
                    <tr>
                        <td>{{ $salary->id }}</td>
                        <td>{{ $salary->formatted_amount }}</td>
                        <td>{{ $salary->month }}</td>
                        <td>{{ $salary->formatted_remaining }}</td>
                        <td>{{ $salary->payment_date }}</td>
                        <td>
                            @if($salary->signature_state == \App\Enums\SignatureState::DONE->value)
                                <span class="badge rounded bg-label-success">
                                    <i class="icon-base bx bx-check icon-sm me-1_0"></i>
                                    {{ $salary->signature_state }}
                                </span>
                            @else                                                
                                <span class="badge rounded bg-label-warning">
                                    <i class="icon-base bx bx-timer icon-sm me-1_0"></i>
                                    {{ $salary->signature_state }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.salary_payments')]) }} </td>
                @endforelse
                @section('pagination')
                    <div class="mt-5 px-5">{{ $teacher->salaryPayments()->paginate(5)->links('vendor.pagination.bootstrap-5') }} </div>
                @endsection
        </x-Table.Tbody>
    </x-Table.BasicTable>
</div>