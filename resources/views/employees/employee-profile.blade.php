<x-header title="{{ $employee->full_name }}"/>

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                <x-alert type="message" />
                <x-alert type="error" />
                   <div class="card col-md-12 col-lg-4 mb-6">
                        <div class="card-body px-0">
                            <div class="d-flex flex-column align-items-center justify-content-center align-items-sm-center gap-6 pb-4 border-bottom px-0">
                                <i class="icon-base bx bx-user icon-sm me-1_5 d-block w-px-50 h-px-50 rounded"></i>
                                <div class="button-wrapper mx-auto d-flex flex-column align-items-center justify-content-center ">
                                    <h4>{{ $employee->full_name }}</h4>
                                    <span class="badge rounded mx-auto bg-label-secondary" title="{{ __('app.phone_one') }}">
                                        {{ $employee->phone_number }}
                                        <i class="icon-base bx bx-phone icon-sm me-1_0"></i>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div class="card-body pt-4 px-0">
                                <div class="card-body demo-vertical-spacing demo-only-element">
                                    <div class="row">
                                        <div class="col-md-6">
                                        <p class="mb-3">@lang('app.employee_name') </p>
                                            <div>
                                                <p>{{ $employee->full_name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <p class="mb-3">@lang('app.salary') </p>
                                            <div>
                                                {{ $employee->formatted_salary }}
                                            </div>
                                        </div>
                                         <div class="col-md-6 mt-3">
                                            <p class="mb-3">@lang('app.phone_one')</p>
                                            <div>
                                                {{ $employee->phone_number }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                          <p class="mb-3">@lang('app.department')</p>
                                            <div>
                                                @if($employee->department == \App\Enums\EmployeeTypes::TEACHER->value)
                                                    <span class="badge rounded bg-warning">
                                                        <i class="icon-base bx bx-user icon-sm me-1_0"></i>
                                                        {{ __('app.teacher') }}
                                                    </span>
                                                @elseif($employee->department == \App\Enums\EmployeeTypes::MANAGER->value)
                                                <span class="badge rounded bg-success">
                                                        <i class="icon-base bx bx-check icon-sm me-1_0"></i>
                                                        {{ __('app.manager') }}
                                                    </span>
                                                @else                                                
                                                    <span class="badge rounded bg-secondary">
                                                        <i class="icon-base bx bx-pin icon-sm me-1_0"></i>
                                                        {{ __('app.worker') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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