<x-header title="{{ __('app.edit') . ' ' . __('app.school') . ' ' . $school->name }}" />
<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <div class="row row g-6 mb-6">
                        <div class="col-md-12">
                            <div class="card container">

                                <x-alert type="message" />
                                <x-alert type="error" />
                            
                                <h4 class="card-header">{{ __('app.edit') . ' ' . __('app.school') . ' ' . $school->name }}</h4>

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="card-body">
                                
                                    <form action="{{ route('schools.update', $school) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">@lang('app.school')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="name" value="{{ $school->name ?? old('name') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class=" mt-4 btn btn-primary">@lang('app.edit')</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer/> 