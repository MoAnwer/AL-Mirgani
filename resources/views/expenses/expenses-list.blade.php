<x-header title="{{ __('app.list', ['attribute' => __('app.the_expenses')]) }}"/>
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
                            <h5 class="card-header">@lang('app.list', ['attribute' => __('app.the_expenses')])</h5>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <td>#</td>
                                    <td>@lang('app.amount')</td>
                                    <td>@lang('app.category')</td>
                                    <td>@lang('app.school')</td>
                                    <td>@lang('app.date')</td>
                                    <td>@lang('app.statement')</td>
                                    <td>@lang('app.created_at')</td>
                                    <td>@lang('app.actions')</td>
                                </x-Table.Thead>
                                <x-Table.Tbody>
                                    @forelse($expenses as $expense)
                                        <tr>
                                            <td>{{ $expense->id }}</td>
                                            <td>{{ $expense->formatted_amount }}</td>
                                            <td>{{ $expense->category->name }}</td>
                                            <td>{{ $expense->school->name }}</td>
                                            <td>{{ $expense->date }}</td>
                                            <td>{{ $expense->statement }}</td>
                                            <td>{{ $expense->formatted_created_at }}</td>
                                            <td>
                                                <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('expenses.edit', $expense) }}"><i class="icon-base bx bx-edit-alt me-1"></i> تعديل</a>
                                                        <a class="dropdown-item" href="{{ route('expenses.delete', $expense) }}"><i class="icon-base bx bx-trash me-1"></i> حذف</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.expenses')]) }} </td>
                                    @endforelse
                                    @section('pagination')
                                        <div class="mt-5 px-5">{{ $expenses->links('vendor.pagination.bootstrap-5') }} </div>
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
