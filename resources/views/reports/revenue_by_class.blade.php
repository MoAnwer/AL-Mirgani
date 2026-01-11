<x-header title="{{ __('app.revenues_by_class_description') }}"/>

<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card px-2 mb-3 py-3">
                    <div class="card-header border-bottom py-4">
                        <h5 class="mb-0 text-start">{{ __('app.filters') }}</h5>
                    </div>
                    <form action="{{ URL::current() }}">
                    <div class="row p-5">
                        <div class="col-4">
                            <label class="form-label">@lang('app.school')</label>
                            <select class="form-select" name="school_id" onchange="this.form.submit()">
                                <option value="{{ null }}" selected>@lang('app.school')</option>
                                    @foreach($schools as $key => $value)
                                        <option value="{{ $value }}" @selected(request()->query('school_id') == $value)>{{ $key }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label">@lang('app.startDate')</label>
                            <div class="input-group">
                                <input type="date" onchange="this.form.submit()" class="form-control" name="start_date" value="{{ request()->query('start_date') }}" />
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label">@lang('app.endDate')</label>
                            <div class="input-group">
                                <input type="date" onchange="this.form.submit()" class="form-control" name="end_date" value="{{ request()->query('end_date') }}" />
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                
                <div class="card">
                <h4 class="text-center pt-4 text-primary">{{ __('app.revenues_by_class_description') }}  - {{ $schoolName }}</h4>
                <p class="text-center lead mb-10">@lang('app.period'): <b>{{ $startDate }}</b> @lang('app.to') <b>{{ $endDate }}</b></p>
                <x-table.basic-table>
                    <x-table.thead>
                        <tr>
                            <th class="text-center">@lang('app.class')</th>
                            <th class="text-center">@lang('app.count_of', ['count' => __('app.the_students')])</th>
                            <th class="text-center">@lang('app.net_total_fees')</th>
                            <th class="text-center">@lang('app.total_amount_collected')</th>
                            <th class="text-center">@lang('app.remaining')</th>
                            <th class="text-center">@lang('app.collection_rate')</th>
                        </tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach ($reportData as $row)
                            <tr>
                                <td class="text-center">{{ __("classes.{$row['class_name']}") }}</td>
                                <td class="text-center">{{ $row['student_count'] }}</td>
                                <td  class="text-center">{{ number_format($row['net_fees']) }}</td>
                                
                                <td class="bg-success-subtle fw-bold text-center">{{ number_format($row['total_paid']) }}</td>
                                
                                <td class="fw-bold text-center
                                    @if ($row['balance_due'] > 0)
                                        text-danger
                                    @else
                                        text-success
                                    @endif
                                ">
                                    {{ number_format($row['balance_due']) }}
                                </td>
                                
                                <td class="text-center">{{ $row['collection_rate'] }}</td>
                            </tr>
                        @endforeach
                    </x-table.tbody>
                    <tfoot>
                        <tr class="table-primary fw-bold">
                            <td class="text-center">@lang('app.total')</td>
                            <td class="text-center">{{ number_format($totalStudents) }}</td>
                            <td  class="text-center">{{ number_format($classTotalFees) }}</td>
                            <td class="text-center">{{ number_format($classTotalPaid) }}</td>
                            
                            <td class="text-center @if ($classBalanceDue > 0) text-danger @else text-success @endif">
                                {{ number_format($classBalanceDue) }}
                            </td>
                            
                            <td class="text-center">{{ number_format($classCollectionRate) }}%</td>
                        </tr>
                    </tfoot>
                </x-table.basic-table>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />