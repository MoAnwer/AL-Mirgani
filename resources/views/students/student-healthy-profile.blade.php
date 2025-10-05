<x-header title="{{__('app.profile', ['attribute' => __('app.student')]) .' '. $student->full_name }}"/>

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>

                <x-alert type="message" />
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif


                    <div class="row">
                        <div class="col-md-12">
                        <div class="nav-align-top">
                            <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('students.show', $student) }}"
                                    ><i class="icon-base bx bx-user icon-sm me-1_5"></i>@lang('app.profile', ['attribute' => __('app.student')])</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('student-healthy-history.show', $student) }}"
                                    ><i class="icon-base bx bx-bell icon-sm me-1_5"></i>@lang('app.healthy_history')</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('students.installments', $student) }}"
                                    ><i class="icon-base bx bx-money icon-sm me-1_5"></i>@lang('app.installments')</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="card mb-6">
                            <!-- Account -->
                            <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                                <i class="icon-base bx bxs-school icon-sm me-1_5 d-block w-px-100 h-px-100 rounded"></i>
                                <div class="button-wrapper">
                                    <h5> @lang('app.healthy_history') - {{ $student->full_name }} </h5>
                                </div>
                            </div>
                            </div>
                            <div class="card-body pt-4">
                                 <div class="card-body demo-vertical-spacing demo-only-element">
                                    <form action="{{ route('student-healthy-history.update', $student) }}" method="POST">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                        <label class="mb-3">@lang('app.diagnosis')</label>
                                            <div class="input-group">
                                              <textarea rows="2" class="form-control" name="diagnosis">{{ $student->healthyHistory->diagnosis }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <label class="mb-3">@lang('app.medication')</label>
                                            <div class="input-group">
                                                 <textarea rows="2" class="form-control" name="medication">{{ $student->healthyHistory->medication->join('')  }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label class="mb-3">@lang('app.notes')</label>
                                            <div class="input-group">
                                                 <textarea rows="6" class="form-control" name="notes">{{ $student->healthyHistory->notes }}</textarea>
                                            </div>
                                        <button type="submit" class="mt-4 btn btn-success">
                                            <i class="icon-base bx bx-edit-alt me-1"></i>
                                            @lang('app.save')
                                        </button>
                                        </div>
                                        
                                    </div>
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
<x-footer/> 
