<x-header title="{{ __('app.list', ['attribute' => __('app.the_earnings')]) }}"/>
    <x-LayoutWrapper>
        <x-LayoutContainer>
            <x-aside />
            <x-LayoutPage>
                <x-nav />
                <x-ContentWrapper>
                    <x-Container>
                        <x-alert type="error" />
                        <x-alert type="message" />

                        <h3 class="card-header mb-5">@lang('app.list', ['attribute' => __('app.the_earnings')])</h3>


                        <div class="card shadow mb-4">
                            <div class="card text-center"> 
                                <div class="card-header border-bottom py-4 mb-3">
                                    <h5 class="mb-0 text-start">{{ __('app.filters') }}</h5>
                                </div>

                                <div class="card-body pb-2">
                                    <form action="{{ URL::current() }}">
                                        <div class="row p-3">
                                            <div class="col-6">
                                                <select class="form-select" name="school_id" onchange="this.form.submit()">
                                                    <option value="{{ null }}" selected>@lang('app.school')</option>
                                                        @foreach($schools as $key => $value)
                                                            <option value="{{ $value }}" @selected(request()->query('school_id') == $value)>{{ $key }}</option>
                                                        @endforeach
                                                </select>
                                            </div>

                                            <div class="col-5">
                                                <div class="input-group" title="{{ __('app.payment_date') }}">
                                                    <input type="date" class="form-control" name="date" value="{{ request()->query('date') }}" onchange="this.form.submit()"/>
                                                </div>
                                            </div>                                   

                                            <button type="submit" class="col-1 btn btn-primary">{{ __('app.search') }}</button>                
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card"> 
                            <h4 class="card-header mb-0 pb-0">
                                @empty(!request()->query('school_id'))
                                    @lang('app.earning') @lang('app.school') {{ array_keys($schools->filter(
                                        fn($id, $name) => $id == request()->query('school_id') ? $name : null
                                        )->toArray())[0]
                                    }}
                                @endempty
                                @empty(!request()->query('date'))
                                    @lang('app.date') {{ request()->query('date') }}
                                @endempty
                            </h4>
                            <x-Table.BasicTable>
                                <x-Table.Thead>
                                    <td>#</td>
                                    <td>@lang('app.amount')</td>
                                    <td>@lang('app.school')</td>
                                    <td>@lang('app.date')</td>
                                    <td>@lang('app.statement')</td>
                                    <td>@lang('app.created_at')</td>
                                </x-Table.Thead>
                                <x-Table.Tbody>
                                    @forelse($earnings as $earning)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $earning->formattedAmount }}</td>
                                            <td>{{ $earning->school?->name ?? 'الادارة' }}</td>
                                            <td>{{ $earning->date->format('Y-m-d') }}</td>
                                            <td>{{ $earning->statement }}</td>
                                            <td>{{ $earning->formatted_created_at }}</td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.earnings')]) }} </td>
                                    @endforelse
                                    <div class="mt-5 px-5">{{ $earnings->links('vendor.pagination.bootstrap-5') }} </div>
                                    @section('pagination')
                                    @endsection
                                </x-Table.Tbody>
                            </x-Table.BasicTable>
                        </div>
                    </x-Container>
                </x-ContentWrapper>
            </x-LayoutPage>
        </x-LayoutContainer>
    </x-LayoutWrapper>
<x-footer />
