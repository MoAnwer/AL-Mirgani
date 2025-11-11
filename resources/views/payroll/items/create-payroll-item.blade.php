<x-header title="{{ __('app.create_new_payroll_item') }}"/>



<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                    <h4 class="mb-0">@lang('app.create_new_payroll_item')</h4>
                    <div class="container my-5">
                        <x-alert type="message" />

                        <div class="card p-5">
                            <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-7">
                                    <div class="form">
                                        <div class="content">
                                            
                                            <form action="{{ route('payroll_items.store') }}" method="POST">
                                                @csrf
                                                
                                                <div class="mb-5">
                                                    <label for="name" class="form-label fw-bold">@lang('app.item_name')</label>
                                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                                        value="{{ old('name') }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-5">
                                                    <label for="type" class="form-label fw-bold">@lang('app.category'):</label>
                                                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                                        <option value="" disabled selected>--  @lang('app.category') --</option>
                                                        @foreach ($itemTypes as $type)
                                                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                                                {{ $type == 'Addition' ? __('app.addition') :  __('app.deduction') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <hr>
                                                
                                                <div class="form-check mb-5">
                                                    <input class="form-check-input" type="checkbox" name="is_fixed" id="is_fixed" value="1" {{ old('is_fixed') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold" for="is_fixed">
                                                        @lang('app.is_fixed')
                                                    </label>
                                                </div>

                                                <div class="mb-5">
                                                    <label for="default_value" class="form-label">@lang('app.default_value'):</label>
                                                    <input type="number" name="default_value" id="default_value" class="form-control @error('default_value') is-invalid @enderror" 
                                                        value="{{ old('default_value', 0) }}" step="0.01">
                                                    @error('default_value')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <button type="submit" class="btn btn-success w-100 mt-3">@lang('app.save')</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer />