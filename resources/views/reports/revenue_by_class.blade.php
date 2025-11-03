<x-header title="تحليل الإيرادات حسب الصف للمرحلة الابتدائية"/>

<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card px-2 mb-3">
                    <form action="{{ URL::current() }}">
                    <div class="row p-3">
                        <div class="col-4">
                            <select class="form-select" name="school_id" onchange="this.form.submit()">
                                <option value="{{ null }}" selected>@lang('app.school')</option>
                                    @foreach($schools as $key => $value)
                                        <option value="{{ $value }}" @selected(request()->query('school_id') == $value)>{{ $key }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <div class="input-group">
                                <input type="date" onchange="this.form.submit()" class="form-control" name="start_date" value="{{ request()->query('start_date') }}" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group">
                                <input type="date" onchange="this.form.submit()" class="form-control" name="end_date" value="{{ request()->query('end_date') }}" />
                            </div>
                        </div>                                  

                        <button type="submit" class="col-1 btn btn-primary">{{ __('app.search') }}</button>                
                    </div>
                </form>
                </div>
                
                <div class="card">
                <h4 class="text-center pt-4 text-primary">تحليل الإيرادات حسب الصف للمرحلة {{ $schoolName }}</h4>
                <p class="text-center lead mb-10">للفترة: <b>{{ $startDate }}</b> الى <b>{{ $endDate }}</b></p>
                <x-table.basic-table>
                    <x-table.thead>
                        <tr>
                            <th class="text-center">الصف</th>
                            <th class="text-center">عدد الطلاب</th>
                            <th class="text-center">صافي الرسوم المستحقة (جنية)</th>
                            <th class="text-center">إجمالي المبلغ المُحصَّل (جنية)</th>
                            <th class="text-center">الرصيد المتبقي (جنية)</th>
                            <th class="text-center">نسبة التحصيل</th>
                        </tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach ($reportData as $row)
                            <tr>
                                <td class="text-center">{{ $row['class_name'] }}</td>
                                <td class="text-center">{{ $row['student_count'] }}</td>
                                <td  class="text-center">{{ number_format($row['net_fees'], 2) }}</td>
                                
                                <td class="bg-success-subtle fw-bold text-center">{{ number_format($row['total_paid'], 2) }}</td>
                                
                                <td class="fw-bold text-center
                                    @if ($row['balance_due'] > 0)
                                        text-danger
                                    @else
                                        text-success
                                    @endif
                                ">
                                    {{ number_format($row['balance_due'], 2) }}
                                </td>
                                
                                <td class="text-center">{{ $row['collection_rate'] }}</td>
                            </tr>
                        @endforeach
                    </x-table.tbody>
                    <tfoot>
                        <tr class="table-primary fw-bold">
                            <td class="text-center">الإجمالي الكلي</td>
                            <td class="text-center">-</td>
                            <td  class="text-center">{{ number_format($classTotalFees, 2) }}</td>
                            <td class="text-center">{{ number_format($classTotalPaid, 2) }}</td>
                            
                            <td class="text-center @if ($classBalanceDue > 0) text-danger @else text-success @endif">
                                {{ number_format($classBalanceDue, 2) }}
                            </td>
                            
                            <td class="text-center">{{ number_format($classCollectionRate, 2) }}%</td>
                        </tr>
                    </tfoot>
                </x-table.basic-table>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />