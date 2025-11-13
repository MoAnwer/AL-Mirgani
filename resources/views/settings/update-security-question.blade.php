<x-header title="{{ __('app.security_questions') .' - '. __('app.edit', ['attribute' => __('app.question')])  }}" />
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card -sm border-0 mb-5">
                    <x-alert type="error" />
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card-body p-4 p-md-5">
                        <header class="mb-4 border-bottom pb-3">
                            <h2 class="h3 fw-bold text-dark">@lang('app.security_questions') - @lang('app.edit', ['attribute' => ''])</h2>
                        </header>
                        <form action="{{ route('settings.update_security_question', $securityQuestion) }}" method="POST" class="row g-3 align-items-end  pb-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12 col-sm-6">
                                <label for="question" class="form-label text-dark fw-medium pb-1">{{ __('app.question') }}:</label>
                                <input type="text" name="question" class="form-control" value="{{ $securityQuestion->question }}">
                            </div>
                            <div class="col-md-12 col-sm-6">
                                <label for="answer" class="form-label text-dark fw-medium pb-1">{{ __('app.answer') }}:</label>
                                <input type="text" name="answer" class="form-control" value="{{ $securityQuestion->answer }}">
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary">@lang('app.edit')</button>
                                <a href="{{ route('settings.page') }}" class=" btn btn-secondary">@lang('app.back')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />
