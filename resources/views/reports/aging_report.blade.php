<x-header title="reports" />
<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
            <h4 class="mb-5
             pb-6">تقرير الأقساط المتأخرة</h4>
            <div class="card p-5">
                <h4 class="mb-6">ملخص تصنيف التأخير</h4>
                <x-table.basic-table>
                    <x-table.thead>
                        <tr>
                            <th class="text-center">إجمالي المتأخر</th>
                            <th class="text-center">1-30 يوم</th>
                            <th class="text-center">31-60 يوم</th>
                            <th class="text-center">61-90 يوم</th>
                            <th class="text-center">أكثر من 90 يوم</th>
                        </tr>
                    </x-table.thead>
                    <x-table.tbody>
                        <tr>
                            <td class="text-center">{{ number_format($agingBuckets['total'], 2) }}</td>
                            <td class="text-center">{{ number_format($agingBuckets['1-30'], 2) }}</td>
                            <td class="text-center">{{ number_format($agingBuckets['31-60'], 2) }}</td>
                            <td class="text-center">{{ number_format($agingBuckets['61-90'], 2) }}</td>
                            <td class="text-center">{{ number_format($agingBuckets['90+'], 2) }}</td>
                        </tr>
                    </x-table.tbody>
                </x-table.basic-table>

                <hr/>

                <h4 class="mb-6">تفاصيل الأقساط المتأخرة</h4>

                <x-table.basic-table>
                    <x-table.thead>
                        <tr>
                            <th class="text-center">الطالب</th>
                            <th class="text-center">الصف</th>
                            <th class="text-center">القسط</th>
                            <th class="text-center">تاريخ الاستحقاق</th>
                            <th class="text-center">المبلغ المستحق</th>
                            <th class="text-center">المبلغ المدفوع</th>
                            <th class="text-center">المبلغ المتأخر</th>
                            <th class="text-center">فترة التأخير (أيام)</th>
                            <th class="text-center">تصنيف التأخير</th>
                        </tr>
                    </x-table.thead>
                    <x-table.tbody>
                       @foreach ($reportData as $row)
                            <tr>
                                <td class="text-center">{{ $row['student_name'] }}</td>
                                <td class="text-center">{{ $row['class_name'] }}</td>
                                <td class="text-center">{{ $row['installment_number'] }}</td>
                                <td class="text-center">{{ $row['due_date'] }}</td>
                                <td class="text-center">{{ number_format($row['amount_due'], 2) }}</td>
                                <td class="text-center">{{ number_format($row['amount_paid'], 2) }}</td>
                                <td class="text-center" style="font-weight: bold; color: red;">{{ number_format($row['balance_due'], 2) }}</td>
                                <td class="text-center">{{ $row['days_overdue'] }}</td>
                                <td class="text-center bg-{{ $row['aging_bucket'] == '90+' ? 'warning' : 'warning' }}">{{ $row['aging_bucket'] }}</td>
                            </tr>
                        @endforeach
                    </x-table.tbody>
                </x-table.basic-table>
            </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />