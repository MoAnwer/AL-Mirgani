<x-header title="{{ __('app.security_questions') }}" />


<div class="container-xxl col-6">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <x-alert type="message" />
          <x-alert type="error" />
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    <div class="app-brand justify-content-center mb-6">
                        <a href=" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <span class="text-primary">
                                </span>
                            </span>
                            <span class="app-brand-text demo text-heading fw-bold">@lang('app.app_name')</span>
                        </a>
                    </div>
                    <h3 class="mb-10">@lang('app.security_questions') 🔒</h3>
                    <h5 class="mb-6">{{ $question }}</h5>
                    <form id="formAuthentication" class="mb-6" action="{{ route('auth.forgot_password.verifyAnswer') }}" method="POST">
                      @csrf
                      @method('POST')
                        <div class="mb-6">
                            <label for="answer" class="form-label">@lang('app.answer')</label>
                            <input type="text" class="form-control" id="answer" name="answer" autofocus />
                        </div>
                        <button class="btn btn-primary d-grid w-100">@lang('app.send_answer')</button>
                    </form>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="d-flex justify-content-center">
                            <i class="icon-base bx bx-chevron-left me-1"></i>
                            @lang('app.back')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>