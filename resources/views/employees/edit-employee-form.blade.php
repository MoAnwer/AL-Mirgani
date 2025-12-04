<x-header title="{{ __('app.edit') .' '. $employee->full_name }}" />
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
                                <h4 class="card-header">{{ __('app.edit') .' '. $employee->full_name }}</h4>
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
                                    <form action="{{ route('employees.update', $employee) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label mb-2">@lang('app.employee_name')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="full_name" value="{{ $employee->full_name ??  old('full_name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label mb-2">@lang('app.phone_one')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  name="phone_number" value="{{ $employee->phone_number ??  old('phone_number') }}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label mb-3">@lang('app.salary')</label>
                                            <input type="number" min="0"  class="form-control"  name="salary" value="{{ $employee->salary ??  old('salary') }}"/>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label mb-3">@lang('app.hire_date')</label>
                                            <input type="date" class="form-control"  name="hire_date" value="{{ $employee->hire_date ??  old('hire_date') }}" max="{{ date('Y-m-d') }}"/>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label mb-3">@lang('app.department')</label>
                                            <select class="form-select" name="department">
                                                <option value="{{ null }}" selected>----</option>
                                                @foreach($departments as $key => $value)
                                                    <option value="{{ $value->value }}" @selected($value->value == $employee->department)>{{ $value->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="col-1 mt-10 btn btn-primary">
                                            @lang('app.save')
                                        </button>
                                        <a href="{{ route('employees.index') }}" class="mt-10 mx-2 col-1 btn btn-secondary"> @lang('app.back') </a>
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