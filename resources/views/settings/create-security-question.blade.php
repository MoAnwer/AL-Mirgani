<x-header title="{{ __('app.settings') .' - '. __('app.create', ['attribute' => __('app.questions')])  }}" />
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card -sm border-0 mb-5">
                    <div class="card-body p-4 p-md-5">
                        <header class="mb-4 border-bottom pb-3">
                            <h2 class="h3 fw-bold text-dark">@lang('app.security_questions') - @lang('app.create', ['attribute' => ''])</h2>
                        </header>

                        <form action="{{ route('settings.store_security_question') }}" method="POST" class="row g-3 align-items-end  pb-3">
                            @csrf
                            @method('POST')
                            <div class="col-md-12 col-sm-6">
                                <label for="start_date" class="form-label text-dark fw-medium pb-1">{{ __('app.question') }}:</label>
                                <input type="text" name="question" onchange="this.form.submit()" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-6">
                                <label for="end_text" class="form-label text-dark fw-medium pb-1">{{ __('app.answer') }}:</label>
                                <input type="text" name="" onchange="this.form.submit()" class="form-control">
                            </div>
                            <button type="submit" class="mt-10 btn btn-primary">@lang('app.save')</button>
                        </form>
                    </div>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />
