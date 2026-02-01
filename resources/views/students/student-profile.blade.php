<x-header title="{{ __('app.profile', ['attribute' => __('app.student')]) .' '. $student->full_name }}" />

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-align-top">
                                <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('students.show', $student) }}"><i class="icon-base bx bx-user icon-sm me-1_5"></i>@lang('app.profile', ['attribute' => __('app.student')])</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('student-healthy-history.show', $student) }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i>@lang('app.healthy_history')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('students.installments', $student) }}"><i class="icon-base bx bx-money icon-sm me-1_5"></i>@lang('app.installments')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('students.registrationFees', $student) }}"><i class="icon-base bx bx-money icon-sm me-1_5"></i>@lang('app.registration_fee')</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card mb-6">
                                <!-- Account -->
                                <div class="card-body">
                                    <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                                        <i class="icon-base bx bx-user icon-sm me-1_5 d-block w-px-100 h-px-100 rounded"></i>
                                        <div class="button-wrapper">
                                            <h3>{{ $student->full_name }}</h3>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary fs-6 pe-2 rounded-pill">@lang('app.student_number') : {{ $student->student_number }}</span>
                                            <span class="badge bg-success-subtle text-success border border-success fs-6 pe-2 rounded-pill">@lang('app.discount') : {{ $student->discount }}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-4">
                                    <div class="card-body demo-vertical-spacing demo-only-element">
                                        <form action="{{ route('students.update', $student->id) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="mb-3">@lang('app.student_full_name')</label>
                                                    <div class="input-group">
                                                        <input readonly type="text" class="form-control" name="full_name" value="{{ $student->full_name }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="mb-3">@lang('app.address')</label>
                                                    <div class="input-group">
                                                        <input readonly type="text" class="form-control" name="address" value="{{ $student->address }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="mb-3">@lang('app.class')</label>
                                                    <div class="input-group">
                                                        <input readonly type="text" class="form-control" name="address" value="{{ __("classes.{$student->class->name}") }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="mb-3">@lang('app.stage')</label>
                                                    <div class="input-group">
                                                        <input readonly type="text" class="form-control" name="stage" value="{{ __("classes.{$student->stage}") }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="mb-3">@lang('app.school')</label>
                                                    <div class="input-group">
                                                        <input readonly type="text" class="form-control" name="school" value="{{ $student->school->name }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="mb-3">@lang('app.total_fee')</label>
                                                    <div class="input-group">
                                                        <input readonly type="number" min="0" class="form-control" name="total_fee" value="{{ $student->total_fee }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="mb-3">@lang('app.phone_one')</label>
                                                    <div class="input-group">
                                                        <input readonly type="number" min="0" class="form-control" name="phone_one" value="{{ $student->father->phone_one }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="mb-3">@lang('app.phone_two')</label>
                                                    <div class="input-group">
                                                        <input readonly type="number" min="0" class="form-control" name="phone_two" value="{{ $student->father->phone_two }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-3">
                                                    <label class="mb-3">@lang('app.parent_full_name')</label>
                                                    <div class="input-group">
                                                        <input readonly type="text" class="form-control" name="parent_full_name" value="{{ $student->father->full_name }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('students.edit', $student) }}" class="mt-5 btn btn-success">
                                                <i class="icon-base bx bx-edit-alt me-1"></i>
                                                @lang('app.edit')
                                            </a>
                                        </form>
                                    </div>
                                </div>
                                <!-- /Account -->
                            </div>
                        </div>
                    </div>
                    </div>
                </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer />
