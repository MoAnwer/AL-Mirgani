<x-header title="{{ __('app.account_scan') }}"/>


<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                    <div class="card text-center mb-2"> 
                        <div class="card-header border-bottom py-4">
                            <h5 class="mb-0 text-start">فلاتر البحث</h5>
                        </div>
                        <form action="{{ URL::current() }}">
                            <div class="row p-3 text-start align-items-end">
                                <div class="col-6">
                                    <label class="mb-1">@lang('app.school')</label>
                                    <select class="form-select" name="school_id" onchange="this.form.submit()">
                                        <option value="{{ null }}" selected>@lang('app.school')</option>
                                            @foreach($schools as $key => $value)
                                                <option value="{{ $value }}" @selected(request()->query('school_id') == $value)>{{ $key }}</option>
                                            @endforeach
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label class="mb-1">@lang('app.date')</label>
                                    <div class="input-group">
                                        <input type="date" onchange="this.form.submit()" class="form-control" name="date" value="{{ request()->query('date') }}" />
                                    </div>
                                </div>                                   

                                <button type="submit" class=" h-0 col-2 btn btn-primary">{{ __('app.search') }}</button>                
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <h3 style="text-align: center;" class="card-header mb-5 mt-4"> {{ __('app.account_scan_day', ['day' =>  $targetDate]) }}</h3>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead  class="table-primary">
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>الواردات (الإيرادات)</th>
                                            <th>المنصرفات (المصروفات)</th>
                                            <th class="text-center">البيان</th>
                                            <th>الرصيد الجاري</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td colspan="3" style="text-align: right; font-weight: bold;">الرصيد المرحل السابق (بداية اليوم)</td>
                                            <td>{{ number_format($previousBalance, 2) }}</td>
                                        </tr>
                                        
                                        @foreach ($reportData as $row)
                                        <tr>
                                            <td>{{ $row['date'] }}</td>
                                            <td class="bg-label-success text-center">{{ $row['type'] === 'income' ? number_format($row['amount'], 2) : '0' }}</td>
                                            <td class="bg-label-danger  text-center">{{ $row['type'] === 'expense' ? number_format($row['amount'], 2) : '0' }}</td>
                                            <td>{{ $row['statement'] }}</td>
                                            <td>{{ number_format($row['running_balance'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot  class="table-secondary">
                                        <tr>
                                            <td style="font-weight: bold;">الإجمالي اليومي:</td>
                                            <td style="font-weight: bold;">{{ number_format($dailyIncomeTotal, 2) }}</td>
                                            <td style="font-weight: bold;">{{ number_format($dailyExpenseTotal, 2) }}</td>
                                            <td style="font-weight: bold;">الرصيد النهائي:</td>
                                            <td style="font-weight: bold;">{{ number_format($finalDailyBalance, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </x-container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>

<x-footer />