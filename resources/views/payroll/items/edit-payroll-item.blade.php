<x-header title="{{ __('app.edit') .' '. __('app.item').': '.$item->name }}" />
<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                    <div class="col-md-12">
                        <div class="card shadow-lg">
                            <div class="card-header text-dark">
                                <h4 class="mb-0">@lang('app.edit') @lang('app.item') :{{ $item->name }}</h4>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('payroll_items.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">@lang('app.item_name')</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    </hr>
                                    <div class="mb-3">
                                        <label for="default_value" class="form-label">@lang('app.default_value')</label>
                                        <input type="number" min="0"  name="default_value" id="default_value" class="form-control @error('default_value') is-invalid @enderror" value="{{ old('default_value', $item->default_value) }}">
                                        @error('default_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-warning w-100 mt-3">@lang('app.edit')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </x-container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer />
