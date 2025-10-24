<x-header title="{{ __('app.report', ['report' => __('app.arrears_installments')]) }}" />
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
            <h4 class="mb-5 pb-6">@lang('app.report', ['report' => __('app.arrears_installments')])</h4>
            <div class="card p-5">
                <h4 class="mb-6">@lang('app.arrears_summarize')</h4>
                <x-table.basic-table>
                    <x-table.thead>
                        <tr>
                            <th class="text-center">@lang('app.total_arrears_days')</th>
                            <th class="text-center">1-30 يوم</th>
                            <th class="text-center">31-60 يوم</th>
                            <th class="text-center">61-90 يوم</th>
                            <th class="text-center">أكثر من 90 يوم</th>
                        </tr>
                    </x-table.thead>
                    <x-table.tbody>
                        <tr>
                            <td class="text-center">{{ number_format($arrearsBuckets['total'], 2) }}</td>
                            <td class="text-center">{{ number_format($arrearsBuckets['1-30'], 2) }}</td>
                            <td class="text-center">{{ number_format($arrearsBuckets['31-60'], 2) }}</td>
                            <td class="text-center">{{ number_format($arrearsBuckets['61-90'], 2) }}</td>
                            <td class="text-center">{{ number_format($arrearsBuckets['90+'], 2) }}</td>
                        </tr>
                    </x-table.tbody>
                </x-table.basic-table>

                <hr/>

                <h4 class="mb-6">@lang('app.arrears_details')</h4>

                <x-table.basic-table>
                    <x-table.thead>
                        <tr>
                            <th class="text-center">@lang('app.student_name')</th>
                            <th class="text-center">@lang('app.class')</th>
                            <th class="text-center">@lang('app.the_installment')</th>
                            <th class="text-center">@lang('app.due_date')</th>
                            <th class="text-center">@lang('app.due_amount')</th>
                            <th class="text-center">@lang('app.paid_amount')</th>
                            <th class="text-center">@lang('app.balance_due')</th>
                            <th class="text-center">@lang('app.days_overdue')</th>
                            <th class="text-center">@lang('app.arrears_bucket')</th>
                        </tr>
                    </x-table.thead>
                    <x-table.tbody>
                       @foreach ($reportData as $row)
                            <tr>
                                <td class="text-center">{{ $row['student_name'] }}</td>
                                <td class="text-center">{{ $row['class_name'] .' '. $row['stage'] }}</td>
                                <td class="text-center">{{ $row['installment_number'] }}</td>
                                <td class="text-center">{{ $row['due_date'] }}</td>
                                <td class="text-center">{{ number_format($row['amount_due'], 2) }}</td>
                                <td class="text-center">{{ number_format($row['amount_paid'], 2) }}</td>
                                <td class="text-center" style="font-weight: bold; color: red;">{{ number_format($row['balance_due'], 2) }}</td>
                                <td class="text-center">{{ $row['days_overdue'] }}</td>
                                <td class="text-center text-black bg-{{ $row['arrears_bucket'] == '90+' ? 'warning' : 'warning' }}">{{ $row['arrears_bucket'] }}</td>
                            </tr>
                        @endforeach
                    </x-table.tbody>
                </x-table.basic-table>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />