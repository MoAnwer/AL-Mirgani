<x-header title="{{ __('app.edit_payroll') }}" />

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <x-alert type="error" />
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold text-warning mb-2">@lang('app.edit_payroll')</h2>
                <p class="lead text-muted">@lang('app.period'): {{ $payroll->month }}/{{ $payroll->year }}</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    
                    <form action="{{ route('payroll.update', $payroll->id) }}" method="POST">
                        @csrf
                        @method('put')
                        
                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label for="employee_id" class="form-label fw-bold">@lang('app.employee')</label>
                                <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="month" class="form-label fw-bold">@lang('app.the_month')</label>
                                <input type="number" name="month" id="month" class="form-control @error('month') is-invalid @enderror" 
                                       value="{{ old('month', $payroll->month) }}" min="1" max="12" required>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="year" class="form-label fw-bold">@lang('app.year')</label>
                                <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" 
                                       value="{{ old('year', $payroll->year) }}" min="2000" required>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="basic_salary_snapshot" class="form-label fw-bold">@lang('app.salary')</label>
                                <div class="input-group">
                                    <input type="number" name="basic_salary_snapshot" id="basic_salary_snapshot" class="form-control @error('basic_salary_snapshot') is-invalid @enderror" 
                                        value="{{ old('basic_salary_snapshot', number_format($payroll->basic_salary_snapshot, 0, '.', '')) }}" required>
                                    <span class="input-group-text">@lang('app.currency')</span>
                                </div>
                                @error('basic_salary_snapshot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">@lang('app.edit_this_value_attention')</small>
                            </div>

                            <div class="col-md-6 my-4">
                                <label class="form-label mb-2">@lang('app.payment_method')</label>
                                <select class="@error('payment_method') is-invalid @enderror form-select" name="payment_method">
                                    <option value="{{ null }}" selected>--</option>
                                    @foreach(['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')] as $key => $value)
                                        <option value="{{ $key }}" @selected($payroll->payment_method == $key)>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 my-4">
                                <label class="form-label mb-2">@lang('app.process_number')</label>
                                <div class="input-group">
                                    <input type="number" class="@error('transaction_id') is-invalid @enderror form-control" name="transaction_id" placeholder="{{ $payroll->transaction_id }}" />
                                </div>
                                @error('transaction_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">@lang('app.edit_do_not_change_this_value')</small>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="payment_status" class="form-label fw-bold">{{ __('app.payment_state') }}</label>
                                <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                    <option value="Pending" {{ old('payment_status', $payroll->payment_status) == 'Pending' ? 'selected' : '' }}>@lang('app.pending')</option>
                                    <option value="Paid" {{ old('payment_status', $payroll->payment_status) == 'Paid' ? 'selected' : '' }}>@lang('app.paid')</option>
                                    <option value="Failed" {{ old('payment_status', $payroll->payment_status) == 'Failed' ? 'selected' : '' }}>@lang('app.failed')</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="payment_date" class="form-label fw-bold">{{ __('app.payment_date') }} </label>
                                <input type="date" name="payment_date" id="payment_date" max="{{ date('Y-m-d') }}" class="form-control @error('payment_date') is-invalid @enderror" 
                                       value="{{ old('payment_date',  $payroll->payment_date?->format('Y-m-d') )}}">
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid mt-4 gap-2">
                            <button type="submit" class="btn btn-warning btn-lg rounded-pill">
                                <i class='bx bxs-save me-2'></i>@lang('app.save') 
                            </button>
                            <a href="{{ route('payroll.index') }}" class="btn btn-outline-secondary rounded-pill">@lang('app.back')</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }
    .card-header {
        border-bottom: none !important;
    }
</style>    