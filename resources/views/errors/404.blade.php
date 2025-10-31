<x-header title="{{ __('app.not_found') }}" />

<div class="container-xxl container-p-y">
    <div class="misc-wrapper">
    <h1 class="mb-2 mx-2" style="line-height: 6rem; font-size: 6rem">404</h1>
    <h4 class="mb-2 mx-2">@lang('app.not_found') ⚠️</h4>
    <p class="mb-6 mx-2">@lang('app.not_found_msg')</p>
    <a href="/" class="btn btn-primary">@lang('app.back')</a>
    <div class="mt-6">
        <img
        src="{{ asset('/assets/img/illustrations/page-misc-error-light.png') }}"
        alt="page-misc-error-light"
        width="400"
        class="img-fluid" />
    </div>
    </div>
</div>