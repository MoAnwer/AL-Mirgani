<x-header title="{{ __('app.edit', ['attribute' => __('app.payment')]) }}" />

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                    <div class="card mb-6">
                        <x-alert type="message" /> 
                        <x-alert type="error" /> 
                        <h5 class="card-header"> 
                            {{ __('app.edit') .' '. __('app.payment') .' '. __('app.the_installment') . ' ' . $payment->installment->number . ' - ' . $payment->installment->student->full_name}} 
                        </h5>
                        <hr />
                        @if($errors->any())
                            <div class="alert alert-danger mx-3">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body pt-4">
                            <div class="card-body demo-vertical-spacing demo-only-element">
                                <form action="{{ route('installments.payments.update', $payment) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-3">
                                        <label class="mb-3">@lang('app.paid_amount', ['attribute' => __('app.the_installment')])</label>
                                            <div class="input-group">
                                                <input type="number" min="0"  name="paid_amount" class="form-control" value="{{ $payment->paid_amount ?? old('paid_amount ') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="mb-3">@lang('app.payment_method')</label>
                                                <select class="form-select" name="payment_method">
                                                <option value="{{ null }}" selected>--</option>
                                                @foreach($paymentMethods as $key => $value)
                                                        <option value="{{ $key }}" @selected($key == $payment->payment_method)>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                         <div class="col-md-3">
                                            <label class="form-label mb-2">@lang('app.process_number')</label>
                                            <div class="input-group">
                                                <input type="number" min="0"  class="@error('transaction_id') is-invalid @enderror form-control" name="transaction_id" placeholder="{{ $payment->transaction_id }}" />
                                            </div>
                                            @error('transaction_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">@lang('app.edit_do_not_change_this_value')</small>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label class="mb-3">@lang('app.payment_date')</label>
                                            <div class="input-group">
                                                <input type="date" name="payment_date" max="{{ date("Y-m-d") }}" class="form-control" value="{{ $payment->payment_date ?? old('payment_date') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="mb-3 mt-4">@lang('app.statement')</label>
                                            <div class="input-group">
                                              <textarea rows="5" class="form-control" name="statement">{{ $payment->statement ?? old('statement') }}</textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="student_id" value="{{ $payment->installment->student->id }}"/>
                                    </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit"> @lang('app.save') </button>
                                    <a  href="{{ route('installments.payments.list', $payment->installment) }}" class="btn btn-secondary"> @lang('app.back') </a>
                                </form>
                                </div>
                            </div>
                        </div>
                    </x-container>
                </x-content-wrapper>
            </x-LayoutPage>
        </x-LayoutContainer>
    </x-LayoutWrapper>
<x-footer/> 
