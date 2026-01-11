<x-header title="{{ __('app.list', ['attribute' => __('app.the_expenses')]) }}" />
<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>
                    <h3>@lang('app.list', ['attribute' => __('app.the_expenses')])</h3>
                    <x-alert type="error" />
                    <x-alert type="message" />

                    <div class="row mx-1 mb-3">
                        <div class="card text-center p-2">
                            <div class="card-header border-bottom py-4 mb-3">
                                <h5 class="mb-0 text-start">{{ __('app.filters') }}</h5>
                            </div>

                            <form action="{{ URL::current() }}">
                                <div class="row p-3">
                                    <div class="col-2">
                                        <select class="form-select" name="category_id" onchange="this.form.submit()">
                                            <option value="{{ null }}" selected>@lang('app.the_category')</option>
                                            @foreach($categories as $key => $value)
                                            <option value="{{ $value }}" @selected(request()->query('category_id') == $value)>{{ __("expenses.$key") }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <select class="form-select" name="school_id" onchange="this.form.submit()">
                                            <option value="{{ null }}" selected>@lang('app.school')</option>
                                            @foreach($schools as $key => $value)
                                            <option value="{{ $value }}" @selected(request()->query('school_id') == $value)>{{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-2">
                                        <div class="input-group">
                                            <input type="date" max="{{ date('Y-m-d') }}" onchange="this.form.submit()" class="form-control" name="date" value="{{ request()->query('date') }}" />
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <input type="number" min="0"  placeholder="{{ __('app.process_number') }}" onchange="this.form.submit()" name="transaction_id" id="transaction_id" class="form-control" value="{{ request('transaction_id') }}">
                                    </div>

                                    <div class="col-2">
                                        <select class="form-select" name="payment_method" onchange="this.form.submit()">
                                            <option value="{{ null }}" selected>-- @lang('app.payment_method') --</option>
                                            @foreach($paymentMethods as $key => $value)
                                            <option value="{{ $key }}" @selected(request()->query('payment_method') == $key)>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="col-1 btn btn-primary">{{ __('app.search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow">
                        <x-Table.BasicTable>
                            <x-Table.Thead>
                                <tr class="text-center">
                                    <td>#</td>
                                    <td>@lang('app.amount')</td>
                                    <td>@lang('app.category')</td>
                                    <td>@lang('app.school')</td>
                                    <td>@lang('app.payment_method')</td>
                                    <td>@lang('app.process_number')</td>
                                    <td>@lang('app.date')</td>
                                    <td>@lang('app.statement')</td>
                                    <td>@lang('app.created_at')</td>
                                <tr>
                            </x-Table.Thead>
                            <x-Table.Tbody>
                                @forelse($expenses as $expense)
                                <tr class="text-center">
                                    <td>{{ $expense->id }}</td>
                                    <td>{{ $expense->formatted_amount }}</td>
                                    <td>{{ __("expenses.{$expense->category->name}") }}</td>
                                    <td>{{ !empty($expense->school->name) ? $expense->school->name : __('app.center') }}</td>
                                    <td>{{ ($expense->payment_method == 'كاش' ? __('app.cash') : __('app.bankak'))   ?? __('app.cash') }}</td>
                                    <td>{{ $expense->transaction_id ?? '' }}</td>
                                    <td>{{ $expense->date->format('Y-m-d') }}</td>
                                    <td>{{ $expense->statement }}</td>
                                    <td>{{ $expense->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <td colspan="9" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.expenses')]) }} </td>
                                @endforelse
                                @section('pagination')
                                <div class="mt-5 px-5">{{ $expenses->withQueryString()->links('vendor.pagination.bootstrap-5') }} </div>
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
