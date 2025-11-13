<x-header title="{{ __('app.settings') }}" />
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card -sm border-0 mb-5">
                    <div class="card-body p-4 p-md-5">
                        <x-alert type="message" />
                        <x-alert type="error" />
                        <header class="mb-4 border-bottom pb-3">
                            <h2 class="h3 fw-bold text-dark">{{ __('app.settings') }}</h2>
                        </header>
                        <div class="p-3  border -sm rounded-3 mb-5">
                            <div class="card-header border-bottom pt-1 pb-3 mb-5 d-flex justify-content-between">
                                <h4 class="mb-0">@lang('app.security_questions')</h4>
                                <a href="{{ route('settings.create_security_question') }}" class="btn btn-primary">
                                    <i class="bx bx-plus-circle me-2"></i>
                                    @lang('app.create', ['attribute' => __('app.question')])
                                </a>
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
                                                    <a class="dropdown-item" href="{{ route('settings.edit_security_question', $securityQuestion) }}"><i class="icon-base text-success bx bx-edit-alt me-1"></i>@lang('app.edit')</a>
                                                    <form action="{{ route('settings.delete_security_question', $securityQuestion) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item" type="submit"><i class="icon-base text-danger bx bx-trash me-1"></i>@lang('app.delete')</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <td colspan="4" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.security_questions')]) }} </td>
                                    @endforelse

                                </x-table.tbody>
                            </x-table.basic-table>
                        </div>

                        <hr class="my-10" />
                        <div class="p-3  border -sm rounded-3 mb-5">
                            <div class="card-header border-bottom pt-1 pb-3 mb-5 d-flex justify-content-between">
                                <h4 class="mb-0">@lang('app.switch_lang')</h4>
                            </div>
                            <form action="{{ route('locale') }}" method="POST" class="row g-3 align-items-end  pb-3 mx-6">
                                @csrf
                                <div class="col-md-12 col-sm-6">
                                    <h6 class="mt-5">@lang('app.current_lang'): <b>{{ __("app.${local}") }}</b></h6>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label for="lang" class="self-center text-gray-700 font-medium">@lang('app.switch_lang'):</label>
                                    <select name="lang" id="lang" onchange="this.form.submit()" class="form-select col-1 my-2">
                                        <option value="en" @if($local == 'en') selected @endif>{{ __('app.english') }}</option>
                                        <option value="ar" @if($local == 'ar') selected @endif>{{ __('app.arabic') }}</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />
