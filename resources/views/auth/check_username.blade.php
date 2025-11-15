<x-header title="{{ __('app.account_verification') }}" />

<div class="container-xxl col-6">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card px-sm-6 px-0">
              <x-alert type="error"/>
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
                    <h3 class="mb-10">@lang('app.account_verification') 🔒</h3>
                    <h5 class="mb-6">@lang('app.enter_your_username')</h5>
                    <form id="formAuthentication" class="mb-6" action="{{ route('auth.forgot_password.verifyAccount') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-6">
                            <label for="username" class="form-label">@lang('app.username')</label>
                            <input type="text" class="form-control" id="username" name="username" autofocus />
                        </div>
                        <button class="btn btn-primary d-grid w-100">@lang('app.verify')</button>
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
