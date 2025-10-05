<x-header title="{{__('app.profile', ['attribute' => __('app.student')]) .' '. $student->full_name }}"/>

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>

                <x-alert type="message" />
                <x-alert type="error" />

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
                                <a class="nav-link" href="{{ route('student-healthy-history.show', $student) }}"
                                ><i class="icon-base bx bx-bell icon-sm me-1_5"></i>@lang('app.healthy_history')</a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('students.installments', $student) }}"
                                ><i class="icon-base bx bx-money icon-sm me-1_5"></i>@lang('app.installments')</a
                                >
                            </li>
                        </ul>
                    </div>
                    <div class="card mb-6 py-0">
                            <!-- Account -->
                            <div class="card-body pb-0">
                            <div class="d-flex justify-content-between align-items-sm-center gap-6 pb-4 border-bottom">
                                <div class="d-flex align-items-start align-items-sm-center">
                                    <i class="icon-base bx bx-money icon-sm me-1_5 d-block w-px-50 h-px-50 rounded"></i>
                                    <div class="button-wrapper">
                                        <h5>@lang('app.student_installments', ['student' => $student->full_name])</h5>
                                    </div>
                                </div>
                                <a class="btn btn-primary text-white" href="{{ route('installments.create', $student->id) }}">@lang('app.create', ['attribute' => __('app.installment')])</a>
                            </div>
                            </div>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <th>#</th>
                                    <th>@lang('app.number', ['attribute' => __('app.installment')])</th>
                                    <th>@lang('app.amount')</th>
                                    <th>@lang('app.due_date')</th>
                                    <th>@lang('app.actions')</th>
                                </x-Table.Thead>
                                <x-Table.Tbody>
                                    @forelse($student->installments as $installment)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $installment->number }}</td>
                                            <td>{{ $installment->amount }}</td>
                                            <td>{{ $installment->due_date }} ({{ $installment->formatted_due_date }})</td>
                                            <td>
                                                <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                       <a class="dropdown-item" href="{{ route('students.edit', $student) }}"><i class="icon-base bx bx-edit-alt me-1"></i>@lang('app.edit')</a>
                                                        <a class="dropdown-item" href="{{ route('students.delete', $student) }}"><i class="icon-base bx bx-trash me-1"></i>@lang('app.delete')</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="5" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.installments')]) }} </td>
                                    @endforelse                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
                                </x-Table.Tbody>
                            </x-Table.BasicTable>    
                        </div>
                    </div>
                </div>
            </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer/> 
