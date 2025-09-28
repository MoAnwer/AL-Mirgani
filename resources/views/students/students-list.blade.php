<x-header title="{{ __('app.list', ['attribute' => __('app.the_students')]) }}"/>
    <x-LayoutWrapper>
        <x-LayoutContainer>
            <x-aside />
            <x-LayoutPage>
                <x-nav />
                <x-ContentWrapper>
                    <x-Container>
                        <x-alert type="error" />
                        <x-alert type="message" />
                        <div class="card"> 
                            <h5 class="card-header">@lang('app.list', ['attribute' => __('app.the_students')])</h5>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <td>#</td>
                                    <td>@lang('app.student_name')</td>
                                    <td>@lang('app.student_number')</td>
                                    <td>@lang('app.address')</td>
                                    <td>@lang('app.class')</td>
                                    <td>@lang('app.stage')</td>
                                    <td>@lang('app.school')</td>
                                    <td>@lang('app.actions')</td>
                                </x-Table.Thead>
                                <x-Table.Tbody>
                                    @forelse($students as $student)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $student->full_name }}</td>
                                            <td>{{ $student->student_number }}</td>
                                            <td>{{ $student->address }}</td>
                                            <td>{{ $student->class->name }}</td>
                                            <td>{{ $student->stage }}</td>
                                            <td>{{ $student->school->name }}</td>
                                            <td>
                                                <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('students.show', $student) }}"><i class="icon-base bx bx-user me-1"></i> ملف التلميذ</a>
                                                        <a class="dropdown-item" href="{{ route('students.edit', $student) }}"><i class="icon-base bx bx-edit-alt me-1"></i> تعديل</a>
                                                        <a class="dropdown-item" href="{{ route('students.delete', $student) }}"><i class="icon-base bx bx-trash me-1"></i> حذف</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.students')]) }} </td>
                                    @endforelse
                                    @section('pagination')
                                        <div class="mt-5 px-5">{{ $students->links('vendor.pagination.bootstrap-5') }} </div>
                                    @endsection
                                </x-Table.Tbody>
                            </x-Table.BasicTable>
                        </div>
                    </x-Container>
                </x-ContentWrapper>
            </x-LayoutPage>
        </x-LayoutContainer>
    </x-LayoutWrapper>
<x-footer />
