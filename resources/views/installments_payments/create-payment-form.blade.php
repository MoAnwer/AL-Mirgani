<x-header title="{{ __('app.create', ['attribute' => __('app.payment')]) }}" />

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                    <div class="card mb-6">
                        <h5 class="card-header"> 
                            {{ __('app.create', ['attribute' => __('app.payment')]) .' - '. __('app.the_installment') . ' ' . $installment->number . ' - ' . $installment->student->full_name}} 
                        </h5>
                        <hr />
                         <x-alert type="message" /> 
                        <x-alert type="error" /> 
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
                                <form action="{{ route('installments.payments.store', $installment) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                        <label class="mb-3">@lang('app.paid_amount', ['attribute' => __('app.the_installment')])</label>
                                            <div class="input-group">
                                                <input type="number" name="paid_amount" class="form-control" value="{{ old('paid_amount') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="mb-3">@lang('app.payment_method')</label>
                                                <select class="form-select" name="payment_method">
                                                <option value="{{ null }}" selected>--</option>
                                                @foreach($paymentMethods as $key => $value)
                                                        <option value="{{ $key }}" @selected(old('payment_method') == $key)>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                        <label class="mb-3">@lang('app.process_number', ['attribute' => __('app.the_installment')])</label>
                                            <div class="input-group">
                                                <input type="number" name="transaction_id" class="form-control" value="{{ old('transaction_id') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="mb-3">@lang('app.payment_date')</label>
                                            <div class="input-group">
                                                <input type="date" name="payment_date" max="{{ date('Y-m-d') }}" class="form-control" value="{{ old('payment_date') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="mb-3 mt-4">@lang('app.notes')</label>
                                            <div class="input-group">
                                              <textarea rows="5" class="form-control" name="statement">{{ old('statement') }}</textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="student_id" value="{{ $installment->student->id }}"/>
                                    </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit"> @lang('app.save') </button>
                                    <a  href="{{ route('installments.payments.list', $installment) }}" class="btn btn-secondary"> @lang('app.back') </a>
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
