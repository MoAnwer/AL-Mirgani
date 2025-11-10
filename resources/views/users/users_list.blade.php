<x-header title="قائمة المستخدمين"/>
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
                                    <h4>@lang('app.list', ['attribute' => __('app.users')])</h4>
                                     <span class="badge bg-success-subtle text-success border border-success rounded-pill fw-bold">
                                        عدد {{ __('app.users') }}:   
                                        {{ $users->count() }}
                                    </span>
                                </div>
                                <a class="btn btn-primary text-white" href="{{ route('users.create') }}">
                                    <i class="bx bx-plus-circle me-3"></i>
                                    @lang('app.create', ['attribute' => __('app.user')])
                                </a>
                            </div>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <tr class="text-center">
                                        <td>#</td>
                                        <td>@lang('app.name')</td>
                                        <td>@lang('app.username')</td>
                                        <td>@lang('app.created_at')</td>
                                        <td>@lang('app.actions')</td>
                                    </tr>
                                </x-Table.Thead>
                                <x-Table.Tbody>
                                    @forelse($users as $user)
                                        <tr class="text-center">
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{'@'.$user->username }}</td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('users.edit', $user) }}"><i class="icon-base text-success bx bx-edit-alt me-1"></i>@lang('app.edit')</a>
                                                        <a class="dropdown-item" href="{{ route('users.delete', $user) }}"><i class="icon-base text-danger bx bx-trash me-1"></i>@lang('app.delete')</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.students')]) }} </td>
                                    @endforelse
                                    @section('pagination')
                                        <div class="mt-5 px-5">{{ $users->withQueryString()->links('vendor.pagination.bootstrap-5') }} </div>
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