<x-header title="{{ __('app.account_scan') }}"/>


<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                    <div class="card">
                        <h3 style="text-align: center;" class="card-header mb-5 mt-4"> {{ __('app.account_scan_day', ['day' =>  $targetDate]) }}</h3>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead  class="table-primary">
                                        <tr>
                                            <th>التاريخ</th>
                                            <th>الواردات (الإيرادات)</th>
                                            <th>المنصرفات (المصروفات)</th>
                                            <th>البيان</th>
                                            <th>الرصيد الجاري</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td colspan="3" style="text-align: right; font-weight: bold;">الرصيد المرحل السابق (بداية اليوم)</td>
                                            <td>{{ number_format($previousBalance, 2) }}</td>
                                        </tr>
                                        
                                        @foreach ($reportData as $row)
                                        <tr>
                                            <td>{{ $row['date'] }}</td>
                                            <td>{{ $row['type'] === 'income' ? number_format($row['amount'], 2) : '' }}</td>
                                            <td>{{ $row['type'] === 'expense' ? number_format($row['amount'], 2) : '' }}</td>
                                            <td>{{ $row['statement'] }}</td>
                                            <td>{{ number_format($row['running_balance'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot  class="table-secondary">
                                        <tr>
                                            <td style="font-weight: bold;">الإجمالي اليومي:</td>
                                            <td style="font-weight: bold;">{{ number_format($dailyIncomeTotal, 2) }}</td>
                                            <td style="font-weight: bold;">{{ number_format($dailyExpenseTotal, 2) }}</td>
                                            <td style="font-weight: bold;">الرصيد النهائي:</td>
                                            <td style="font-weight: bold;">{{ number_format($finalDailyBalance, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </x-container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>

<x-footer />