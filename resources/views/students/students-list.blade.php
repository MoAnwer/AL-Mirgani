<x-header title="{{ $title }}"/>
    <x-LayoutWrapper>
        <x-LayoutContainer>
            <x-aside />
            <x-LayoutPage>
                <x-nav />
                <x-ContentWrapper>
                    <x-Container>
                        <div class="card">
                            <h5 class="card-header">@lang('app.students_list')</h5>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <td>#</td>
                                    <td>اسم الطالب</td>
                                    <td>الرقم المدرسي</td>
                                    <td>العنوان</td>
                                    <td>الصف</td>
                                    <td>المرحلة</td>
                                    <td>المدرسة</td>
                                    <td>العمليات</td>
                                </x-Table.Thead>
                                <x-Table.Tbody>
                                    @foreach($students as $student)
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
                                                        <a class="dropdown-item" href="{{ route('students.destroy', $student) }}"><i class="icon-base bx bx-trash me-1"></i> حذف</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
