<x-header title="{{ __('app.create', ['attribute' => __('app.earning')]) }}" />
<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <div class="row row g-6 mb-6">
                        <div class="col-md-12">
                            <div class="card container">

                                <x-alert type="message" />
                                <x-alert type="error" />
                            
                                <h4 class="card-header">@lang('app.create', ['attribute' => __('app.earning')])</h4>

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="card-body">
                                
                                    <form action="{{ route('earnings.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label mb-2">@lang('app.amount')</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="amount" value="{{ old('amount') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-2">@lang('app.school')</label>
                                            <select class="form-select" name="school_id">
                                                <option value="{{ null }}" selected>--</option>
                                                    @foreach($schools as $key => $value)
                                                        <option value="{{ $value }}" @selected(old('school_id') == $value)>{{ $key }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-2">@lang('app.payment_method')</label>
                                            <select class="form-select" name="payment_method">
                                                <option value="{{ null }}" selected>--</option>
                                                @foreach(['كاش' => __('app.cash'), 'بنكك'  => __('app.bankak')] as $key => $value)
                                                    <option value="{{ $key }}" @selected(old('payment_method') == $key)>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                         <div class="col-md-6 mt-4">
                                            <label class="form-label mb-2">@lang('app.process_number')</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="transaction_id" value="{{ old('transaction_id') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="form-label mb-2">@lang('app.date')</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="date" value="{{ old('date') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-5">
                                            <label class="form-label mb-2">@lang('app.statement')</label>
                                            <div class="input-group">
                                              <textarea rows="10" class="form-control" name="statement">{{ old('statement') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class=" mt-4 btn btn-primary">@lang('app.save')</button>
                                    <a href="{{ route('earnings.index') }}" class="btn btn-secondary mt-4">@lang('app.back')</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer/> 