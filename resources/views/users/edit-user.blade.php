<x-header title="{{ __('app.edit', ['attribute' => __('app.user')]) }}" />

<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <div class="card -sm border-0 mb-5">
                        <div class="card-body p-4 p-md-5">
                            <x-alert type="message" />
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

                            <div class="p-3  border -sm rounded-3 mb-5 shadow-sm">
                                <div class="card-header border-bottom pt-1 pb-3 mb-5">
                                    <h4>{{ __('app.edit') .' '. $user->name}} </h4>
                                </div>

                                <form action="{{ route('users.update', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label class="form-label mb-2">@lang('app.name')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="name" value="{{ $user->name ?? old('name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label class="form-label mb-2">@lang('app.username')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="username" value="{{  $user->username ?? old('username') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-7 btn btn-success">@lang('app.edit')</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>

<x-footer />
