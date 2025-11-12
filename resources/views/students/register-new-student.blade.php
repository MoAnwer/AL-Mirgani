<x-header title="{{ $title }}" />

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
                            
                                <h4 class="card-header">{{ $title }}</h4>

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

                                    <form action="{{ route('students.store') }}" method="POST">
                                    
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label class="form-label mb-2">@lang('app.student_full_name')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="full_name" value="{{ old('full_name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mb-2">@lang('app.address')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  name="address" value="{{ old('address') }}"/>
                                            </div>
                                        </div>
                                         <div class="col-md-4">
                                            <label class="form-label">@lang('app.class')</label>
                                            <select class="form-select" name="class">
                                                <option value="{{ null }}" selected>----</option>
                                                @foreach($classes as $key => $value)
                                                    <option value="{{ $value }}" @selected(old('class') == $value)>{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">@lang('app.stage')</label>
                                            <select class="form-select" name="stage">
                                                <option value="{{ null }}" selected>----</option>
                                                @foreach($stages as $value)
                                                    <option value="{{ $value->value }}" @selected(old('stage') == $value->value)>{{ $value->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">@lang('app.school')</label>
                                            <select class="form-select" name="school">
                                                <option value="{{ null }}" selected>----</option>
                                                @foreach($schools as $key => $value)
                                                    <option value="{{ $value }}" @selected(old('school') == $value)>{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label mb-2">@lang('app.total_fee')</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control"  name="total_fee" value="{{ old('total_fee') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label mb-2">@lang('app.discount')</label>
                                            <div class="input-group">
                                                <input type="number" max="100" class="form-control" name="discount" value="{{ old('discount') }}"/>
                                            </div>
                                        </div>
                                        <div class="my-5">
                                        <hr />
                                            <h5>@lang('app.parent_data')</h5>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label mb-2">@lang('app.parent_full_name')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"  name="parent_name" value="{{ old('parent_name') }}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label mb-2">@lang('app.phone_one')</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"  name="phone_one" value="{{ old('phone_one') }}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label mb-2">@lang('app.phone_two')</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"  name="phone_two" value="{{ old('phone_two') }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div>
                                        <hr />
                                            <h5 class="mb-5">@lang('app.registration_data')</h5>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-2">@lang('app.registration_fee')</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="registration_fee" value="{{ old('registration_fee') }}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label mb-2">@lang('app.paid_amount')</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"  name="paid_amount" value="{{ old('paid_amount') }}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label mb-2">@lang('app.payment_method')</label>
                                                    <select class="form-select" name="payment_method">
                                                    <option value="{{ null }}" selected>--</option>
                                                        @foreach([__('app.cash'), __('app.bankak')] as $value)
                                                            <option value="{{ $value }}" @selected(old('payment_method') == $value)>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label class="form-label mb-2">@lang('app.process_number')</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" placeholder= "@lang('app.process_number')" name="transaction_id" value="{{ old('transaction_id') }}"/>
                                                    </div>
                                                </div>
                                                 <div class="col-md-2">
                                                 <label class="form-label mb-2">{{ __('app.payment_date') }}</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" name="payment_date" value="{{ old('payment_date') }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class=" mt-4 btn btn-primary">@lang('app.save')</button>
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