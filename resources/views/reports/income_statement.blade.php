<x-header title="قائمة الدخل (الإيرادات والمصروفات)"/>

<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
            <div class="container my-5">
                <div class="card px-2 mb-3">
                    <form action="{{ URL::current() }}">
                    <div class="row p-3">
                        <div class="col-4">
                            <select class="form-select" name="school_id">
                                <option value="{{ null }}" selected>@lang('app.school')</option>
                                    @foreach($schools as $key => $value)
                                        <option value="{{ $key }}" @selected(request()->query('school_id') == $key)>{{ $value }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <div class="input-group">
                                <input type="date" class="form-control" name="start_date" value="{{ request()->query('start_date') }}" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group">
                                <input type="date" class="form-control" name="end_date" value="{{ request()->query('end_date') }}" />
                            </div>
                        </div>                                  

                        <button type="submit" class="col-1 btn btn-primary">{{ __('app.search') }}</button>                
                    </div>
                </form>
                </div>
                <div class="card">
                    <h2 class="pt-6 text-center mb-1 text-dark">قائمة الدخل (الإيرادات والمصروفات)</h2>
                    @if(!empty($selected_school))
                        <h5 class="py-3 text-center">@lang('app.school') {{ $selected_school?->name}}</h5>
                    @else
                        <h5 class="py-3 text-center">لكل المدارس</h5>
                    @endif
                    <p class="text-center lead">للفترة: <b>{{ $period }}</b></p>
                
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr class="table-success-subtle fw-bold">
                                    <td colspan="2">الإيرادات التشغيلية:</td>
                                    <td class="text-end"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>رسوم الأقساط والتعليم</td>
                                    <td class="text-end">{{ number_format($revenue['fees'], 2) }}</td>
                                </tr>
                                <tr class="bg-success text-white fw-bold">
                                    <td colspan="2">إجمالي الإيرادات (أ)</td>
                                    <td class="text-end">{{ number_format($revenue['total'], 2) }}</td>
                                </tr>

                                <tr class="table-danger-subtle fw-bold">
                                    <td colspan="2" class="pt-4">المصروفات التشغيلية:</td>
                                    <td class="text-end"></td>
                                </tr>
                                @foreach ($operating_expenses as $expense)
                                    <tr>
                                        <td></td>
                                        <td>{{ $expense[1] }}</td>
                                        <td class="text-end text-danger">({{ number_format($expense[0], 2) }})</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-danger text-white fw-bold">
                                    <td colspan="2">إجمالي المصروفات التشغيلية (ب)</td>
                                    <td class="text-end text-white">({{ number_format($total_operating, 2) }})</td>
                                </tr>

                                <tr class="table-info fw-bold">
                                    <td colspan="2">صافي الدخل التشغيلي (أ - ب)</td>
                                    <td class="text-end">{{ number_format($netOperatingIncome, 2) }}</td>
                                </tr>

                                <tr class="fw-bold">
                                    <td colspan="2" class="pt-4">مصروفات أخرى (غير تشغيلية):</td>
                                    <td class="text-end"></td>
                                </tr>
                                 @foreach ($non_operating_expenses as $expense)
                                    <tr>
                                        <td></td>
                                        <td>{{ $expense[1] }}</td>
                                        <td class="text-end text-danger">({{ number_format($expense[0], 2) }})</td>
                                    </tr>
                                @endforeach
                               
                                
                                <tr class="table-primary fw-bolder fs-5">
                                    <td colspan="2">صافي الربح / (الخسارة)</td>
                                    <td class="text-end 
                                        @if ($netProfit >= 0) text-success @else text-danger @endif
                                    ">
                                        @if ($netProfit < 0)
                                            ({{ number_format(abs($netProfit), 2) }}) 
                                        @else
                                            {{ number_format($netProfit, 2) }}
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