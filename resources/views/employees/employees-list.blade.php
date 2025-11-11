<x-header title="{{ __('app.list', ['attribute' => __('app.the_employees')]) }}"/>
    <x-layout-wrapper>
        <x-layout-container>
            <x-aside />
            <x-layout-page>
                <x-nav />
                <x-content-wrapper>
                    <x-container>
                        <x-alert type="error" />
                        <x-alert type="message" />
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-sm-center gap-6 pb-4 border-bottom">
                                <div class="d-flex align-items-start align-items-sm-center px-3">
                                    <div class="button-wrapper">
                                        <h4 class="card-header">@lang('app.list', ['attribute' => __('app.the_employees')])</h4>
                                    </div>
                                </div>
                                <a class="btn btn-primary text-white m-5 mt-10" href="{{ route('employees.create') }}">
                                    <i class="icon-base bx bx-plus-circle icon-sm me-1_5 d-block rounded"></i>
                                    @lang('app.create', ['attribute' => __('app.employee')])
                                </a>
                            </div>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <tr class="text-center">
                                        <td>#</td>
                                        <td>@lang('app.the_employee')</td>
                                        <td>@lang('app.phone_one')</td>
                                        <td>@lang('app.salary') (جنية)</td>
                                        <td>@lang('app.department')</td>
                                        <td>@lang('app.actions')</td>
                                    </tr>
                                </x-Table.Thead>
                                <x-Table.Tbody>
                                    @forelse($employees as $employee)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $employee->full_name }}</td>
                                            <td>{{ $employee->phone_number }}</td>
                                            <td>{{ $employee->formatted_salary }}</td>
                                            <td>
                                                @if($employee->department == \App\Enums\EmployeeTypes::TEACHER->value)
                                                    <span class="badge bg-warning-subtle text-warning border border-warning rounded-pill  py-1 px-2">
                                                        <i class="icon-base bx bx-user icon-sm me-1_0"></i>
                                                        {{ $employee->department }}
                                                    </span>
                                                @elseif($employee->department == \App\Enums\EmployeeTypes::MANAGER->value)
                                                <span class="badge bg-success-subtle text-success border border-success rounded-pill  py-1 px-2">
                                                        <i class="icon-base bx bx-check icon-sm me-1_0"></i>
                                                        {{ $employee->department }}
                                                    </span>
                                                @else                                                
                                                    <span class="badge bg-info-subtle text-info border border-info rounded-pill py-1 px-2">
                                                        <i class="icon-base bx bx-pin icon-sm me-1_0"></i>
                                                        {{ $employee->department }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown mx-5">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('employees.show', $employee) }}"><i class="icon-base bx bx-user me-1"></i>@lang('app.profile', ['attribute' => __('app.employee')])</a>
                                                        <a class="dropdown-item" href="{{ route('employees.edit', $employee) }}"><i class="icon-base bx bx-edit-alt me-1"></i>@lang('app.edit')</a>
                                                        <a class="dropdown-item" href="{{ route('employees.delete', $employee) }}"><i class="icon-base bx bx-trash me-1"></i>@lang('app.delete')</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.employees')]) }} </td>
                                    @endforelse
                                    @section('pagination')
                                        <div class="mt-5 px-5">{{ $employees->links('vendor.pagination.bootstrap-5') }} </div>
                                    @endsection
                                </x-Table.Tbody>
                            </x-Table.BasicTable>
                        </div>
                    </x-container>
                </x-content-wrapper>
            </x-layout-page>
        </x-layout-container>
    </x-layout-wrapper>
<x-footer />
