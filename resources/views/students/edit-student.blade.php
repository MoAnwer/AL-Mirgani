
<x-header title="{{ __('app.edit') . ' ' .  $student->full_name }}" />

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

                                @session('message')
                                    <div class="alert alert-success text-black mt-5">{{ session('message') }}</div>
                                @endsession
                            
                                <h4 class="card-header">{{ __('app.edit') . ' ' .  $student->full_name }}</h4>

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
                                    <form action="{{ route('students.update', $student->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                        <label class="mb-3">@lang('app.student_full_name')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  name="full_name" value="{{ $student->full_name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <label class="mb-3">@lang('app.address')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="{{ __('app.address') }}"  name="address" value="{{ $student->address }}"/>
                                            </div>
                                        </div>
                                         <div class="col-md-6 mt-3">
                                            <label class="mb-3">@lang('app.class')</label>
                                            <select class="form-select" name="class_id">
                                                @foreach($classes as $key => $value)
                                                    <option value="{{ $value }}" @selected($student->class->name == $key)>{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                        <label class="mb-3">@lang('app.stage')</label>
                                            <select class="form-select" name="stage">
                                                @foreach($stages as $value)
                                                    <option value="{{ $value->value }}" @selected($student->stage == $value->value)>{{ $value->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                        <label class="mb-3">@lang('app.school')</label>
                                            <select class="form-select" name="school_id">
                                                <option selected>-- @lang('app.school') --</option>
                                                @foreach($schools as $key => $value)
                                                    <option value="{{ $value }}" @selected($student->school->name == $key)>{{ $key }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                        <label class="mb-3">@lang('app.total_fee')</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control"  name="total_fee" value="{{ $student->total_fee }}"/>
                                            </div>
                                        </div>
                                        </div>
                                        <button type="submit" class="mt-4 btn btn-success">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>
                                            @lang('app.edit')
                                        </button>
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