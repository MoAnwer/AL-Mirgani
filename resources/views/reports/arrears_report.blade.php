<x-header title="{{ __('app.report', ['report' => __('app.arrears_installments')]) }}" />
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <h4 class="mb-6">@lang('app.arrears_details')</h4>
                    <div class="card text-center mb-2 pb-4"> 
                        <div class="card-header border-bottom py-4">
                            <h5 class="mb-0 text-start">فلاتر البحث</h5>
                        </div>
                        <form method="GET">
                            <div class="row p-3 text-start align-items-end">
                                <div class="col-4">
                                    <label class="mb-1">@lang('app.school')</label>
                                    <select class="form-select" name="school_id" onchange="this.form.submit()">
                                        <option value="{{ null }}" selected>@lang('app.school')</option>
                                            @foreach($schools as $school)
                                                <option value="{{ $school->id }}" @selected(request()->query('school_id') == $school->id)>{{ $school->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="mb-1">@lang('app.class')</label>
                                    <select class="form-select" name="class_id" onchange="this.form.submit()">
                                        <option value="{{ null }}" selected>@lang('app.class')</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" @selected(request()->query('class_id') == $class->id)>{{ $class->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <label class="mb-1">@lang('app.due_date')</label>
                                    <div class="input-group">
                                        <input type="date" onchange="this.form.submit()" class="form-control" name="date" value="{{ request()->query('date') }}" />
                                    </div>
                                </div>                                   
                                <button type="submit" class=" h-0 col-1 flex-grow-1 mx-2 btn btn-primary">{{ __('app.search') }}</button>                
                            </div>
                        </form>
                    </div>
                <div class="card p-5">
                <x-table.basic-table>
                    <x-table.thead>
                        <tr class="fw-bold">
                            <th class="text-center fw-bold">@lang('app.student_name')</th>
                            <th class="text-center fw-bold">@lang('app.class')</th>
                            <th class="text-center fw-bold">@lang('app.the_installment')</th>
                            <th class="text-center fw-bold">@lang('app.due_date')</th>
                            <th class="text-center fw-bold">@lang('app.due_amount')</th>
                            <th class="text-center fw-bold">@lang('app.paid_amount')</th>
                            <th class="text-center fw-bold">@lang('app.balance_due')</th>
                            <th class="text-center fw-bold">@lang('app.days_overdue')</th>
                        </tr>
                    </x-table.thead>
                    <x-table.tbody>
                       @forelse ($reportData as $row)
                            <tr>
                                <td class="text-center">{{ $row['student_name'] }}</td>
                                <td class="text-center">{{ $row['class_name'] }}</td>
                                <td class="text-center">{{ $row['installment_number'] }}</td>
                                <td class="text-center">{{ $row['due_date'] }}</td>
                                <td class="text-center">{{ number_format($row['amount_due']) }}</td>
                                <td class="text-center">{{ number_format($row['amount_paid']) }}</td>
                                <td class="text-center" style="font-weight: bold; color: red;">{{ number_format($row['balance_due']) }}</td>
                                <td class="text-center">{{ $row['days_overdue'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center fw-bold py-8">
                                    لاتوجد بيانات مطابقة لفلاتر البحث
                                </td>
                            </tr>
                        @endforelse
                        <div class="mt-4">
                            @section('pagination')
                                <div class="mt-5 px-5">{{ $reportData->withQueryString()->links('vendor.pagination.bootstrap-5') }} </div>
                            @endsection
                        </div>
                    </x-table.tbody>
                </x-table.basic-table>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />