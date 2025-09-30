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
                        <div class="card"> 
                            <h5 class="card-header">@lang('app.list', ['attribute' => __('app.the_earnings')])</h5>
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
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $earning->formatted_amount }}</td>
                                            <td>{{ $earning->school->name }}</td>
                                            <td>{{ $earning->date }}</td>
                                            <td>{{ $earning->statement }}</td>
                                            <td>{{ $earning->formatted_created_at }}</td>
                                        </tr>
                                    @empty
                                        <td colspan="8" class="text-center"> {{ __('app.empty_message', ['attributes' => __('app.earnings')]) }} </td>
                                    @endforelse
                                    @section('pagination')
                                        <div class="mt-5 px-5">{{ $earnings->links('vendor.pagination.bootstrap-5') }} </div>
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
