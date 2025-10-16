<x-header :title="$title" />
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
                                <h4 class="card-header">{{ $title }}</h4>
                                <hr />
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card-body demo-vertical-spacing demo-only-element">
                                    <form action="{{ route('teachers.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label mb-2">@lang('app.teacher_name')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label mb-2">@lang('app.phone_one')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"  name="phone" value="{{ old('phone') }}"/>
                                            </div>
                                        </div>
                                         <div class="col-md-6 mt-3">
                                            <label class="form-label mb-3">@lang('app.salary')</label>
                                            <input type="number" class="form-control"  name="salary" value="{{ old('salary') }}"/>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="form-label mb-3">@lang('app.rule')</label>
                                            <select class="form-select" name="rule">
                                                <option value="{{ null }}" selected>----</option>
                                                @foreach($rules as $key => $value)
                                                    <option value="{{ $value->value }}" @selected(old('rule') == $value->value)>{{ $value->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="col-1 mt-10 btn btn-primary">
                                            @lang('app.save')
                                        </button>
                                        <a href="{{ route('teachers.index') }}" class="mt-10 mx-2 col-1 btn btn-secondary"> @lang('app.back') </a>
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