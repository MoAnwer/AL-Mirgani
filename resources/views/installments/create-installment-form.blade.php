<x-header title="{{ __('app.create', ['attribute' => __('app.installment')]) }}" />

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <div class="card mb-6">
                        <h5 class="card-header"> {{ $studentName. ' - ' .__('app.create', ['attribute' => __('app.installment')]) }} </h5>
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
                                <form action="{{ route('installments.store', $id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                        <label class="mb-3">@lang('app.number', ['attribute' => __('app.the_installment')])</label>
                                            <div class="input-group">
                                                <input type="text" name="number" class="form-control" value="{{ old('number') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        <label class="mb-3">@lang('app.amount')</label>
                                            <div class="input-group">
                                                <input type="text"  name="amount" class="form-control" value="{{ old('amount') }}" />
                                            </div>
                                        </div>
                                            <div class="col-md-4">
                                            <label class="mb-3">@lang('app.due_date')</label>
                                            <div class="input-group">
                                                <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" />
                                            </div>
                                            <input type="hidden" name="student_id" value="{{ $id }}" />
                                        </div>
                                    </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit"> @lang('app.save') </button>
                                    <a  href="{{ route('students.installments', $id) }}" class="btn btn-secondary"> @lang('app.back') </a>
                                </form>
                                </div>
                            </div>
                        </div>
                    </x-Container>
                </x-ContentWrapper>
            </x-LayoutPage>
        </x-LayoutContainer>
    </x-LayoutWrapper>
<x-footer/> 
