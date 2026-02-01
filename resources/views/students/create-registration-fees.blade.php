<x-header title="{{ __('app.create', ['attribute' => __('app.registration_fee')]) }}" />

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <div class="card mb-6">
                        <h5 class="card-header"> {{ $student->full_name. ' - ' . __('app.add') . ' ' . __('app.registration_fee') }} </h5>
                        <hr />
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="card-body pt-4">
                            <x-alert type="message" />
                            <x-alert type="error" />
                            <div class="card-body demo-vertical-spacing demo-only-element">
                                <form action="{{ route('students.registrationFees.store', $student) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label mb-3">@lang('app.amount')</label>
                                            <div class="input-group">
                                                <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label mb-3">@lang('app.paid_amount')</label>
                                            <div class="input-group">
                                                <input type="number" name="paid_amount" class="form-control" value="{{ old('paid_amount') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                        <label class="form-label mb-2">@lang('app.payment_method')</label>
                                        <select class="form-select" name="payment_method">
                                            <option value="{{ null }}" selected>--</option>
                                            @foreach($paymentMethods as $key => $value)
                                            <option value="{{ $key }}" @selected(old('payment_method')==$key)>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-2">@lang('app.process_number')</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control" value="{{ old('transaction_id') ?? null }}" placeholder="@lang('app.process_number')" name="transaction_id" value="{{ old('transaction_id') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-2">{{ __('app.payment_date') }}</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="payment_date" max="{{ date('Y-m-d') }}" value="{{ old('payment_date') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <button class="btn btn-primary" type="submit"> @lang('app.save') </button>
                        <a href="{{ route('students.registrationFees', $student) }}" class="btn btn-secondary"> @lang('app.back') </a>
                        </form>
                    </div>
                    </div>
                    </div>
                </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer />
