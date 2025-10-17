<x-header title="{{ __('app.list', ['attribute' => __('app.the_teachers')]) }}"/>
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
                                        <h4 class="card-header">@lang('app.list', ['attribute' => __('app.the_teachers')])</h4>
                                    </div>
                                </div>
                                <a class="btn btn-primary text-white m-5 mt-10" href="{{ route('teachers.create') }}">
                                    <i class="icon-base bx bx-plus-circle icon-sm me-1_5 d-block rounded"></i>
                                    @lang('app.create', ['attribute' => __('app.teacher')])
                                </a>
                            </div>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <td>#</td>
                                    <td>@lang('app.teacher_name')</td>
                                    <td>@lang('app.phone_one')</td>
                                    <td>@lang('app.salary')</td>
                                    <td>@lang('app.rule')</td>
                                    <td>@lang('app.actions')</td>
                                </x-Table.Thead>
                                <x-Table.Tbody>
                                    @forelse($teachers as $teacher)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $teacher->name }}</td>
                                            <td>{{ $teacher->phone }}</td>
                                            <td>{{ $teacher->formatted_salary }}</td>
                                            <td>
                                                @if($teacher->rule == \App\Enums\TeacherRule::contribute->value)
                                                    <span class="badge rounded bg-label-warning">
                                                        <i class="icon-base bx bx-user icon-sm me-1_0"></i>
                                                        {{ $teacher->rule }}
                                                    </span>
                                                @else                                                
                                                    <span class="badge rounded bg-label-success">
                                                        <i class="icon-base bx bx-pin icon-sm me-1_0"></i>
                                                        {{ $teacher->rule }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown mx-5">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('teachers.show', $teacher) }}"><i class="icon-base bx bx-user me-1"></i>@lang('app.profile', ['attribute' => __('app.teacher')])</a>
                                                        <a class="dropdown-item" href=""><i class="icon-base bx bx-edit-alt me-1"></i>@lang('app.edit')</a>
                                                        <a class="dropdown-item" href=""><i class="icon-base bx bx-trash me-1"></i>@lang('app.delete')</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.teachers')]) }} </td>
                                    @endforelse
                                    @section('pagination')
                                        <div class="mt-5 px-5">{{ $teachers->links('vendor.pagination.bootstrap-5') }} </div>
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
