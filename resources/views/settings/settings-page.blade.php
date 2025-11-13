<x-header title="{{ __('app.settings') }}" />
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card -sm border-0 mb-5">
                    <div class="card-body p-4 p-md-5">
                        <header class="mb-4 border-bottom pb-3">
                            <h2 class="h3 fw-bold text-dark">{{ __('app.settings') }}</h2>
                        </header>
                        <div class="p-3  border -sm rounded-3 mb-5">
                            <div class="card-header border-bottom pt-1 pb-3 mb-5">
                                <h5 class="mb-0">@lang('app.security_questions')</h5>
                            </div>

                            <x-table.basic-table>
                                <x-table.thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>@lang('app.question')</th>
                                        <th>@lang('app.answer')</th>
                                        <th>@lang('app.actions')</th>
                                    </tr>
                                </x-table.thead>
                                <x-table.tbody>
                                    @forelse ($securityQuestions as $securityQuestion)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $securityQuestion->question }}</td>
                                            <td>{{ $securityQuestion->answer }}</td>
                                             <td>
                                                <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        {{-- <a class="dropdown-item" href="{{ route('users.edit', $user) }}"><i class="icon-base text-success bx bx-edit-alt me-1"></i>@lang('app.edit')</a> --}}
                                                        {{-- <a class="dropdown-item" href="{{ route('users.delete', $user) }}"><i class="icon-base text-danger bx bx-trash me-1"></i>@lang('app.delete')</a> --}}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>    
                                    @empty
                                        <td colspan="4" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.security_questions')]) }} </td>
                                    @endforelse
                                    
                                </x-table.tbody>
                            </x-table.basic-table>
{{-- 
                            <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end  pb-3">
                                <div class="col-md-6 col-sm-6">
                                    <label for="start_date" class="form-label text-dark fw-medium pb-1">{{ __('app.question') }}</label>
                                    <input type="text" name="question" onchange="this.form.submit()" class="form-control">
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label for="end_text" class="form-label text-dark fw-medium pb-1">{{ __('app.answer') }}</label>
                                    <input type="text" name="" onchange="this.form.submit()" class="form-control">
                                </div>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />
