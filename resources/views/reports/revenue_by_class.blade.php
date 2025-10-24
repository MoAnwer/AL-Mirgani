<x-header title="تحليل الإيرادات حسب الصف للمرحلة الابتدائية"/>

<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card">
                <h4 class="text-center py-4 mb-6 text-primary">تحليل الإيرادات حسب الصف للمرحلة {{ $schoolName }}</h4>
    
                <x-table.basic-table>
                    <x-table.thead>
                        <tr>
                            <th class="text-center">الصف/المرحلة</th>
                            <th class="text-center">عدد الطلاب</th>
                            <th class="text-center">صافي الرسوم المستحقة (جنية)</th>
                            <th class="text-center">إجمالي المبلغ المُحصَّل (جنية)</th>
                            <th class="text-center">الرصيد المتبقي (جنية)</th>
                            <th class="text-center">نسبة التحصيل</th>
                        </tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach ($reportData as $row)
                            <tr>
                                <td class="text-center">{{ $row['class_name'] }}</td>
                                <td class="text-center">{{ $row['student_count'] }}</td>
                                <td  class="text-center">{{ number_format($row['net_fees'], 2) }}</td>
                                
                                <td class="bg-success-subtle fw-bold text-center">{{ number_format($row['total_paid'], 2) }}</td>
                                
                                <td class="fw-bold text-center
                                    @if ($row['balance_due'] > 0)
                                        text-danger
                                    @else
                                        text-success
                                    @endif
                                ">
                                    {{ number_format($row['balance_due'], 2) }}
                                </td>
                                
                                <td class="text-center">{{ $row['collection_rate'] }}</td>
                            </tr>
                        @endforeach
                    </x-table.tbody>
                    <tfoot>
                        <tr class="table-primary fw-bold">
                            <td class="text-center">الإجمالي الكلي</td>
                            <td class="text-center">-</td>
                            <td  class="text-center">{{ number_format($classTotalFees, 2) }}</td>
                            <td class="text-center">{{ number_format($classTotalPaid, 2) }}</td>
                            
                            <td class="text-center @if ($classBalanceDue > 0) text-danger @else text-success @endif">
                                {{ number_format($classBalanceDue, 2) }}
                            </td>
                            
                            <td class="text-center">{{ number_format($classCollectionRate, 2) }}%</td>
                        </tr>
                    </tfoot>
                </x-table.basic-table>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />