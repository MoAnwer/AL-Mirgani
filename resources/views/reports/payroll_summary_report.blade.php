<x-header title="{{ __('app.total_payrolls_report') }}"/>


<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <header class="mb-2 border-b pb-4">
                    <h3 class="text-3xl font-bold text-gray-800">@lang('app.total_payrolls_report')</h3>
                    <p class="text-gray-500">@lang('app.total_payrolls_report_description', ['year' => $targetYear])</p>
                </header>
                <div class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-lg">
                    <div class="mb-6 flex justify-start items-center space-x-4 space-x-reverse">
                        <form action="{{ url()->current() }}" method="GET" class="flex space-x-4 space-x-reverse w-25">
                            <label for="year" class="self-center text-gray-700 font-medium">@lang('app.year'):</label>
                            <select name="year" id="year" onchange="this.form.submit()" class="form-select col-1 my-2">
                                @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                    <option value="{{ $year }}" @if($year == $targetYear) selected @endif>{{ $year }}</option>
                                @endfor
                            </select>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <x-table.basic-table>
                            <x-table.thead>
                                <tr class="text-center">
                                    <th class="py-5 fw-bold">
                                       @lang('app.period_year_month')
                                    </th>
                                    <th class="py-5 fw-bold">
                                        @lang('app.total') @lang('app.salary')
                                    </th>
                                    <th class="py-5 fw-bold">
                                        @lang('app.total')  @lang('expenses.حوافز مالية')
                                    </th>
                                    <th class="py-5 fw-bold">
                                       @lang('app.total_deductions')
                                    </th>
                                    <th class="py-5 fw-bold">
                                        @lang('app.total_due_amount')
                                    </th>
                                </tr>
                            </x-table.thead>
                            <x-table.tbody>
                                @php
                                    $grandTotalBasic = 0;
                                    $grandTotalAllowances = 0;
                                    $grandTotalDeductions = 0;
                                    $grandTotalNet = 0;
                                @endphp
                                @forelse ($reportData as $data)

                                    <tr class="text-center">
                                        <td class="px-6 py-4">
                                            {{ $data['period'] }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ number_format($data['basic_salary']) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ number_format($data['total_allowances'] + $data['total_additions'])}}
                                        </td>
                                        <td class="px-6 py4">
                                            {{ number_format($data['total_deductions']) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data['net_paid_amount'] }}
                                        </td>
                                    </tr>
                                    @php
                                        $grandTotalBasic += (float) str_replace(['.', ','], '', $data['basic_salary']);
                                        $grandTotalAllowances += (float) str_replace(['.', ','], '', $data['total_allowances'] + $data['total_additions']);
                                        $grandTotalDeductions += (float) str_replace(['.', ','], '', $data['total_deductions']);
                                        $grandTotalNet += (float) str_replace(['.', ','], '', $data['net_paid_amount']);
                                    @endphp
                                @empty
                                    <tr class="text-center">
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-lg">
                                           @lang('app.empty_message', ['attributes' => __('app.payrolls')]).
                                        </td>
                                    </tr>
                                @endforelse

                                <tr class="bg-label-success text-center fw-bold">
                                    <td class="px-6 py-4">@lang('app.total')</td>
                                    <td class="px-6 py-4">
                                        {{ number_format($grandTotalBasic) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ number_format($grandTotalAllowances) }}
                                    </td>
                                    <td class="px-6 py-4 ">
                                        {{ number_format($grandTotalDeductions) }}
                                    </td>
                                    <td class="px-6 py-4 ">
                                        {{ number_format($grandTotalNet) }}
                                    </td>
                                </tr>

                            </x-table.tbody>
                        </x-table.basic-table>
                    </div>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />