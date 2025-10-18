<x-header title="{{ __('app.create', ['attribute' => __('app.salary')])}}"/>
<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                    <div class="row row g-6 mb-6">
                        <div class="col-md-12">
                            <div class="card container">
                                <x-alert type="message" />
                                <x-alert type="error" />
                                <h4 class="card-header">{{ __('app.create', ['attribute' => __('app.payment')])}}</h4>
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
                                <div class="card-body demo-vertical-spacing demo-only-element">
                                    <form action="{{ route('teacher.salary-payment.store', $teacher) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label mb-2">@lang('app.amount')</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="amount" value="{{ old('amount') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label mb-2">@lang('app.the_month')</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control"  name="month" value="{{ old('month') }}" max="12"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label mb-3">@lang('app.payment_date')</label>
                                            <input type="date" class="form-control"  name="payment_date" value="{{ old('payment_date') }}"/>
                                        </div>
                                        <div class="col-md-3 mt-5">
                                            <label class="form-label">@lang('app.signature_state')</label>
                                            <select class="form-select" name="signature_state">
                                                <option value="{{ null }}" selected>----</option>
                                                @foreach(\App\Enums\SignatureState::cases() as $value)
                                                    <option value="{{ $value->value }}" @selected(old('signature_state') == $value->value)>{{ $value->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mt-3">
                                            <label class="form-label mb-2">@lang('app.statement')</label>
                                                <div class="input-group">
                                                    <textarea  class="form-control"  rows="10" name="statement">{{ old('statement') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}"/>
                                        <button type="submit" class="col-1 mt-10 btn btn-primary">
                                            @lang('app.save')
                                        </button>
                                        <a href="{{ route('teachers.show', $teacher) }}" class="mt-10 mx-2 col-1 btn btn-secondary"> @lang('app.back') </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer/> 