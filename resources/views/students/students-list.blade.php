<x-header title="{{ __('app.list', ['attribute' => __('app.the_students')]) }}" />
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
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div>
                                <h4>@lang('app.list', ['attribute' => __('app.the_students')])</h4>
                                <span class="badge bg-success-subtle text-success border border-success rounded-pill fw-bold">
                                    @lang('app.count_of', ['count' => __('app.the_students')]):
                                    {{ $students->count('id') }}
                                </span>
                            </div>

                            <form action={{ URL::current() }}>
                                <div class="input-group">
                                    <input type="search" placeholder="{{ __('app.search') }} ..." class="form-control" name="search" value="{{ request('search') }}" />
                                </div>
                            </form>
                        </div>
                        <x-Table.BasicTable>
                            <x-Table.Thead>
                                <tr class="text-center">
                                    <td>#</td>
                                    <td>@lang('app.student_name')</td>
                                    <td>@lang('app.student_number')</td>
                                    <td>@lang('app.address')</td>
                                    <td>@lang('app.class')</td>
                                    <td>@lang('app.stage')</td>
                                    <td>@lang('app.school')</td>
                                    <td>@lang('app.actions')</td>
                                <tr>
                            </x-Table.Thead>
                            <x-Table.Tbody>
                                @forelse($students as $student)
                                <tr class="text-center">

                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->student_number }}</td>
                                    <td>{{ $student->address }}</td>
                                    <td>{{ is_null($student->class->name) ? __("classes.{$student->class->name}") : __('app.not_specify') }}</td>
                                    <td>{{ !is_null($student->stage) ? __("classes.{$student->stage}") : __('app.not_specify')  }}</td>
                                    <td>{{ $student->school->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('students.accounts', $student->id) }}"><i class="icon-base bx bx-news text-warning me-1"></i>@lang('app.account_scan')</a>
                                                <a class="dropdown-item" href="{{ route('students.show', $student) }}"><i class="icon-base text-primary bx bx-user me-1"></i>@lang('app.profile', ['attribute' => __('app.student')])</a>
                                                <a class="dropdown-item" href="{{ route('students.edit', $student) }}"><i class="icon-base text-success bx bx-edit-alt me-1"></i>@lang('app.edit')</a>
                                                <a class="dropdown-item" href="{{ route('students.delete', $student) }}"><i class="icon-base text-danger bx bx-trash me-1"></i>@lang('app.delete')</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.students')]) }} </td>
                                @endforelse
                                @section('pagination')
                                <div class="mt-5 px-5">{{ $students->withQueryString()->links('vendor.pagination.bootstrap-5') }} </div>
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
