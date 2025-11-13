<x-header title="{{ __('app.security_questions') .' - '. __('app.create', ['attribute' => __('app.question')])  }}" />
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card -sm border-0 mb-5">

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
                            <h2 class="h3 fw-bold text-dark">@lang('app.security_questions') - @lang('app.create', ['attribute' => ''])</h2>
                        </header>

                        <form action="{{ route('settings.store_security_question') }}" method="POST" class="row g-3 align-items-end  pb-3">
                            @csrf
                            @method('POST')
                            <div class="col-md-12 col-sm-6">
                                <label for="start_date" class="form-label text-dark fw-medium pb-1">{{ __('app.question') }}:</label>
                                <input type="text" name="question" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-6">
                                <label for="end_text" class="form-label text-dark fw-medium pb-1">{{ __('app.answer') }}:</label>
                                <input type="text" name="answer" class="form-control">
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary">@lang('app.save')</button>
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
