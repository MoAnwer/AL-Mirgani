<x-header title="{{ __('app.create_new_payroll') }}" />


<x-layout-wrapper>
    <x-layout-container>
        <x-aside />
        <x-layout-page>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                <x-alert type="message" />
                <x-alert type="error" />

                    <h4 class="mb-10">{{ __('app.create_new_payroll') }}</h3>

                        <div class="row">
                            <div class="col-md-12">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card shadow-lg">
                                    <div class="card-body">
                                        <form action="{{ route('payroll.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="employee_id" class="form-label  mb-3 fw-bold">{{ __('app.select_employee') }}</label>
                                                    <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                                                        <option value="" disabled selected>--{{ __('app.select_employee')  }}--</option>
                                                        @foreach ($employees as $employee)
                                                            <option value="{{ $employee->id }}" 
                                                                data-salary="{{ $employee->salary }}"
                                                                data-fixed-allowance="{{ $employee->fixed_allowances }}"
                                                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                                {{ $employee->full_name }} (أساسي: {{ number_format($employee->salary, 2) }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('employee_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="month" class="form-label mb-3 ">@lang('app.the_month')</label>
                                                    <input type="number" name="month" id="month" class="form-control" value="{{ old('month', $defaultMonth) }}" min="1" max="12" required>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="year" class="form-label mb-3 ">@lang('app.year')</label>
                                                    <input type="number" name="year" id="year" class="form-control" value="{{ old('year', $defaultYear) }}" min="2020" required>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="total_fixed_allowances" class="form-label te mb-3 xt-success">@lang('app.fixed_allowances')</label>
                                                    <input type="number" name="total_fixed_allowances" id="total_fixed_allowances" class="form-control @error('total_fixed_allowances') is-invalid @enderror" 
                                                        value="{{ old('total_fixed_allowances', 0) }}" step="0.01" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="total_variable_additions" class="form-label te mb-3 xt-success">@lang('app.total_variable_additions')</label>
                                                    <input type="number" name="total_variable_additions" id="total_variable_additions" class="form-control @error('total_variable_additions') is-invalid @enderror" 
                                                        value="{{ old('total_variable_additions', 0) }}" step="0.01" required>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="total_deductions" class="form-label te mb-3 xt-danger">@lang('app.total_deductions')</label>
                                                    <input type="number" name="total_deductions" id="total_deductions" class="form-control @error('total_deductions') is-invalid @enderror" 
                                                        value="{{ old('total_deductions', 0) }}" step="0.01" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="payment_status" class="form-label  mb-3 fw-bold">{{ __('app.payment_state') }}</label>
                                                    <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                                        <option value="Pending" {{ old('payment_status') == 'Pending' ? 'selected' : '' }}>@lang('app.pending')</option>
                                                        <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>@lang('app.paid')</option>
                                                        <option value="Failed" {{ old('payment_status') == 'Failed' ? 'selected' : '' }}> @lang('app.failed')</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="payment_date" class="form-label  mb-3 fw-bold">{{ __('app.payment_date') }} </label>
                                                    <input type="date" name="payment_date" id="payment_date" class="form-control @error('payment_date') is-invalid @enderror" 
                                                        >
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100 mt-3">@lang('app.save')</button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </x-container>
            </x-content-wrapper>
        </x-layout-page>
    </x-layout-container>
</x-layout-wrapper>
<x-footer/> 