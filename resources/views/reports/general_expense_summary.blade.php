<x-header title="{{ __('app.general_expense_report') }}" />

    <style>
        .card-expense {
            border-right: 5px solid #dc3545; 
        }
    </style>



<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                    <div class="card -sm border-0 mb-5">
                        <div class="card-body p-4 p-md-5">
                            <header class="mb-4 border-bottom pb-3">
                                <h1 class="h3 fw-bold text-dark">{{ __('app.general_expense_report') }}</h1>
                                <p class="text-muted">{{ __('app.expenses_report_description') }}</p>
                            </header>
                            <div class="p-3  border -sm rounded-3 mb-5">
                                <div class="card-header border-bottom pt-1 pb-3 mb-5">
                                    <h5 class="mb-0">{{ __('app.filters') }}</h5>
                                </div>
                                <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end  pb-3">
                                    <div class="col-md-3 col-sm-6">
                                        <label for="school_id" class="form-label text-dark fw-medium pb-1">{{ __('app.all_schools')  }}</label>
                                        <select name="school_id" id="school_id" class="form-select" onchange="this.form.submit()">
                                            <option value="{{ null }}">{{ __('app.all_schools') }}</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}" @selected(request('school_id') == $school->id)>{{ $school->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-6">
                                        <label for="start_date" class="form-label text-dark fw-medium pb-1">{{ __('app.startDate') }}</label>
                                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" onchange="this.form.submit()"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <label for="end_date" class="form-label text-dark fw-medium pb-1">{{ __('app.endDate') }}</label>
                                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" onchange="this.form.submit()"
                                            class="form-control">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label text-dark fw-medium pb-1">@lang('app.the_category')</label>
                                        <select class="form-select" name="category_id" onchange="this.form.submit()">
                                        <option value="{{ null }}" selected>---</option>
                                            @foreach($categories as $key => $value)
                                                <option value="{{ $value }}" @selected(request()->query('category_id') == $value)>{{ __("expenses.$key") }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                            <label class="form-label text-dark fw-medium pb-1">@lang('app.payment_method')</label>
                                            <select class="form-select" name="payment_method" onchange="this.form.submit()">
                                                <option value="{{ null }}" selected>----</option>
                                                    @foreach($paymentMethods as $key => $value)
                                                <option value="{{ $key }}" @selected(request()->query('payment_method') == $key)>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>

                            <div class="card card-expense border border-danger p-5">
                                <div class="card-body p-4 ">
                                    <h2 class="h5 text-dark mb-3">{{ __('app.expenses_report_total_amount_title') }}</h2>
                                    <p class="lead">@lang('app.period'): <b>{{ $period }}</b></p>
                                    @if(request()->query('payment_method'))
                                        <p class="lead">{{ request()->query('payment_method') }}</p>
                                    @endif
                                    @if(request()->query('category_id'))
                                        @foreach($categories as $key => $value)
                                            @if($value == request()->query('category_id'))
                                                <p class="lead">@lang('app.category') : <b>{{ $key }}</b></p>
                                            @endif
                                        @endforeach    
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="display-5 fw-bolder text-danger mb-0">
                                            {{ $reportData['total_amount'] }} {{ __('app.currency')}}
                                        </p>
                                        <i class="bx bx-dollar text-danger opacity-50" style="font-size: 3rem;"></i>
                                    </div>
                                    <p class="text-secondary mt-3 mb-0">
                                       {{ __('app.expense_report_amount_description') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />