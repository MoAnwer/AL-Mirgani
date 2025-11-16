<x-header title="{{ __('app.income_statement_title') }}"/>

<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
            <div class="container my-5">
                <div class="card px-2 mb-3">
                    <div class="card-header border-bottom py-4 mb-3">
                        <h5 class="mb-0 text-start">{{ __('app.filters') }}</h5>
                    </div>
                    <form action="{{ URL::current() }}">
                    <div class="row p-3 mb-2">
                        <div class="col-3">
                            <label class="form-label py-2">@lang('app.school')</label>
                            <select class="form-select" name="school_id" onchange="this.form.submit()">
                                <option value="{{ null }}" selected>---</option>
                                    @foreach($schools as $key => $value)
                                        <option value="{{ $key }}" @selected(request()->query('school_id') == $key)>{{ $value }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label py-2">@lang('app.startDate')</label>
                            <div class="input-group">
                                <input type="date" class="form-control" onchange="this.form.submit()" name="start_date" value="{{ request()->query('start_date') }}" />
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label py-2"> @lang('app.endDate') </label>
                            <div class="input-group">
                                <input type="date" class="form-control" onchange="this.form.submit()" name="end_date" value="{{ request()->query('end_date') }}" />
                            </div>
                        </div>   
                        <div class="col-3">
                            <label class="form-label py-2">@lang('app.payment_method')</label>
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
                    <h2 class="pt-6 text-center mb-1 text-dark">@lang('app.income_statement_title')</h2>
                    @if(!empty($selected_school))
                        <h5 class="py-3 text-center">@lang('app.school') {{ $selected_school?->name}}</h5>
                    @else
                        <h5 class="py-3 text-center">@lang('app.all_schools')</h5>
                    @endif

                    @if(!empty(request()->query('payment_method')))
                        <h5 class="py-0 text-center">@lang('app.earning') {{ request()->query('payment_method') }}</h5>
                    @endif

                    <p class="text-center lead">@lang('app.period'): <b>{{ $period }}</b></p>
                    
                
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr class="table-success-subtle fw-bold">
                                    <td colspan="2">@lang('app.operating_earnings') :</td>
                                    <td class="text-end"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>@lang('app.edu_fees')</td>
                                    <td class="text-end">{{ number_format($revenue['fees']) }}</td>
                                </tr>
                                <tr class="bg-success text-white fw-bold">
                                    <td colspan="2">@lang('app.total_earnings') (1)</td>
                                    <td class="text-end">{{ number_format($revenue['total']) }}</td>
                                </tr>

                                <tr class="table-danger-subtle fw-bold">
                                    <td colspan="2" class="pt-4">@lang('app.operating_expenses') :</td>
                                    <td class="text-end"></td>
                                </tr>
                                @foreach ($operating_expenses as $expense)
                                    <tr>
                                        <td></td>
                                        <td>{{ $expense[1] }}</td>
                                        <td class="text-end text-danger">({{ number_format($expense[0]) }})</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-danger fw-bold">
                                    <td colspan="2" class="text-white">  @lang('app.total_operating_expenses') (2)</td>
                                    <td class="text-end text-white">({{ number_format($total_operating) }})</td>
                                </tr>

                                <tr class="table-info fw-bold">
                                    <td colspan="2">@lang('app.total_operating_profit')  (1 - 2)</td>
                                    <td class="text-end">{{ number_format($netOperatingIncome) }}</td>
                                </tr>

                                <tr class="fw-bold">
                                    <td colspan="2" class="pt-4">@lang('app.non_operating_expenses') :</td>
                                    <td class="text-end"></td>
                                </tr>
                                 @foreach ($non_operating_expenses as $expense)
                                    <tr>
                                        <td></td>
                                        <td>{{ $expense[1] }}</td>
                                        <td class="text-end text-danger">({{ number_format($expense[0]) }})</td>
                                    </tr>
                                @endforeach
                               
                                
                                <tr class="table-primary fw-bolder fs-5">
                                    <td colspan="2">@lang('app.net_profit_or_lose')</td>
                                    <td class="text-end 
                                        @if ($netProfit >= 0) text-success @else text-danger @endif">
                                        @if ($netProfit < 0)
                                            ({{ number_format(abs($netProfit)) }}) 
                                        @else
                                            {{ number_format($netProfit) }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />