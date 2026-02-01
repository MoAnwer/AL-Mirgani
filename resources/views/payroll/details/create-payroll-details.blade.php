<x-header title="{{ __('app.create_payroll_detail_item') }}"/>

<x-layout-wrapper>
    <x-layout-container>
        <x-aside />
        <x-layout-page>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                <x-alert type="message" />
                <x-alert type="error" />
                <div class="row justify-content-center">
                        <h3>@lang('app.create_payroll_detail_item')</h3>
                        <div class="col-md-12">
                            <div class="mb-4">
                                <p class="lead">
                                    @lang('app.employee'): <strong class="text-dark">{{ $payroll->employee->full_name }}</strong> | 
                                    @lang('app.period'): <strong class="text-dark">{{ $payroll->month }}/{{ $payroll->year }}</strong>
                                </p>
                            </div>

                            <div class="card shadow-lg">
                                <div class="card-body p-4">
                                    <form action="{{ route('payroll.details.store', $payroll->id) }}" method="POST">
                                        @csrf
                                            <div class="mb-3">
                                                <label for="item_id" class="form-label fw-bold">@lang('app.item_name')</label>
                                                <select name="item_id" id="item_id" class="form-select @error('item_id') is-invalid @enderror" required>
                                                    <option value="{{ null }}" disabled selected>----</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }} - ({{ __("app.". strtolower($item->type) .'') }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('item_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="amount" class="form-label fw-bold">@lang('app.amount')</label>
                                                <input type="number" min="0"  name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                                    value="{{ old('amount') }}" step="0.01" required>
                                                @error('amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="date" class="form-label fw-bold">@lang('app.date')</label>
                                                <input type="date" max="{{ date('Y-m-d') }}"  name="date" id="date" class="form-control @error('date') is-invalid @enderror" 
                                                    value="{{ old('date') }}" required>
                                                @error('date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="notes" class="form-label fw-bold">@lang('app.statement')</label>
                                                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success">@lang('app.save')</button>
                                            <a href="{{ route('payroll.show', $payroll->id) }}" class="btn btn-secondary">@lang('app.back')</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                </x-container>
            </x-content-wrapper>
        </x-layout-page>
    </x-layout-container>
</x-layout-wrapper>
<x-footer/> 