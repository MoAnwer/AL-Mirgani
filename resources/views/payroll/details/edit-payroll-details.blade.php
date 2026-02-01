<x-header title="{{ __('app.edit_payroll_detail') }}"/>

<div class="container my-10">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="text-center mb-4">
                <h2 class="text-primary">@lang('app.edit_payroll_detail')</h2>
                <p class="lead">
                    @lang('app.employee'): <strong class="text-dark">{{ $payroll->employee->full_name }}</strong> | 
                    @lang('app.detail_name'): <strong class="text-dark">{{ $detail->item->name }}</strong>
                </p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    
                    <form action="{{ route('payroll.details.update', ['payroll' => $payroll->id, 'detail' => $detail->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">@lang('app.detail_name')</label>
                            <input type="text" class="form-control" value="{{ $detail->item->name }} ({{ $detail->item->type }})" disabled>
                            <input type="hidden" name="item_id" value="{{ $detail->item_id }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-bold">@lang('app.amount')</label>
                            <div class="input-group">
                                <input type="number" min="0"  name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                       value="{{ old('amount', $detail->amount) }}" step="1" required placeholder="500.00">
                                <span class="input-group-text">@lang('app.currency')</span>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">@lang('app.notes')</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2">{{ old('notes', $detail->notes) }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill">
                                <i class='bx bxs-save me-2'></i> @lang('app.save')
                            </button>
                            <a href="{{ route('payroll.show', $payroll->id) }}" class="btn btn-outline-secondary rounded-pill">
                                <i class='bx bx-undo me-2'></i> @lang('app.back')
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
