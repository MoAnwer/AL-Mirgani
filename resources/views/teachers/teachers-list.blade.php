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
                            <h5 class="card-header">@lang('app.list', ['attribute' => __('app.the_teachers')])</h5>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <td>#</td>
                                    <td>@lang('app.teacher_name')</td>
                                    <td>@lang('app.phone_one')</td>
                                    <td>@lang('app.school')</td>
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
                                            <td>{{ $student->school->name }}</td>
                                            <td>{{ \Illuminate\Support\Number::currency($teacher->salary, 'SDG',  precision: 0) }}</td>
                                            <td>{{ $teacher->rule }}</td>
                                            <td>
                                                <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href=""><i class="icon-base bx bx-user me-1"></i>@lang('app.profile', ['attribute' => __('app.student')])</a>
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
