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
                            <h5 class="mb-0 text-start">{{ __('app.filters') }}</h5>
                        </div>
                        <form action="{{ URL::current() }}">
                            <div class="row p-3 text-start align-items-end p-6">
                                <div class="col-4">
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
                                        <input type="date" onchange="this.form.submit()" class="form-control" max="{{ date('Y-m-d') }}" name="date" value="{{ request()->query('date') }}" />
                                    </div>
                                </div>      
                                
                                 <div class="col-4">
                                    <select class="form-select" name="payment_method" onchange="this.form.submit()">
                                        <option value="{{ null }}" selected>-- @lang('app.payment_method') --</option>
                                        @foreach($paymentMethods as $key => $value)
                                            <option value="{{ $key }}" @selected(request()->query('payment_method') == $key)>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <h3 style="text-align: center;" class="card-header mb-5 mt-4"> {{ __('app.account_scan_day', ['day' =>  $targetDate]) }}</h3>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead  class="table-primary">
                                        <tr class="text-center">
                                            <th>@lang('app.date')</th>
                                            <th>@lang('app.the_earnings')</th>
                                            <th>@lang('app.the_expenses')</th>
                                            <th class="text-center">@lang('app.statement')</th>
                                            <th> @lang('app.current_balance')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td></td>
                                            <td colspan="3" style="text-align: right; font-weight: bold;">@lang('app.forward_balance')</td>
                                            <td>{{ number_format($previousBalance) }}</td>
                                        </tr>
                                        
                                        @foreach ($reportData as $row)
                                        <tr class="text-center">
                                            <td>{{ $row['date'] }}</td>
                                            <td class="bg-label-success text-center">{{ $row['type'] === 'income' ? number_format($row['amount']) : '0' }}</td>
                                            <td class="bg-label-danger  text-center">{{ $row['type'] === 'expense' ? number_format($row['amount']) : '0' }}</td>
                                            <td>{{ $row['statement'] }}</td>
                                            <td>{{ number_format($row['running_balance']) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot  class="table-secondary">
                                        <tr class="text-center">
                                            <td style="font-weight: bold;">@lang('app.total_for_the_day'):</td>
                                            <td style="font-weight: bold;" class="text-center">{{ number_format($dailyIncomeTotal) }}</td>
                                            <td style="font-weight: bold;" class="text-center">{{ number_format($dailyExpenseTotal) }}</td>
                                            <td style="font-weight: bold;">@lang('app.final_balance'):</td>
                                            <td style="font-weight: bold;">{{ number_format($finalDailyBalance) }}</td>
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