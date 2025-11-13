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
                                <h5 class="mb-0">{{ __('app.filters') }}</h5>
                            </div>
                            <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end  pb-3">
                                <div class="col-md-3 col-sm-6">
                                    <label for="start_date" class="form-label text-dark fw-medium pb-1">{{ __('app.startDate') }}</label>
                                    <input type="date" name="start_date" onchange="this.form.submit()" class="form-control">
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="end_date" class="form-label text-dark fw-medium pb-1">{{ __('app.endDate') }}</label>
                                    <input type="date" name="end_date" onchange="this.form.submit()" class="form-control">
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
