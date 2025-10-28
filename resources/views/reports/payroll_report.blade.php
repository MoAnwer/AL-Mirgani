<x-header title="sdf" />

<div class="container my-5">
    <h2 class="text-center mb-2 text-primary">تقرير كشف الرواتب والمزايا</h2>
    <p class="text-center lead">
        لشهر: <span class="badge bg-secondary fs-6">{{ $targetMonth }}/{{ $targetYear }}</span>
    </p>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered text-end align-middle">
                
                <thead class="table-primary-header">
                    <tr>
                        <th class="text-center" rowspan="2">اسم الموظف / القسم</th>
                        <th class="text-center" rowspan="2">الراتب الأساسي</th>
                        <th class="text-center text-success" colspan="2">المستحقات (الإضافات والمزايا)</th>
                        <th class="text-center text-danger" rowspan="2">الاستقطاعات الإجمالية</th>
                        <th class="text-center bg-info-custom text-black" rowspan="2">صافي المستحق الدفع</th>
                        <th class="text-center" rowspan="2">تكلفة المؤسسة الكلية</th>
                    </tr>
                    <tr class="table-primary-header">
                        <th class="text-center">إجمالي الإضافات</th>
                        <th class="text-center">إجمالي المستحقات (Gross)</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($reportData as $row)
                    <tr>
                        <td class="text-center fw-bold">{{ $row['employee_name'] }}</td>
                        <td>{{ number_format($row['basic_salary'], 2) }}</td>
                        
                        <td class="text-success fw-bold">{{ number_format($row['additions'], 2) }}</td>
                        
                        <td class="table-warning fw-bold">{{ number_format($row['gross_salary'] ?? 0, 2) }}</td>
                        
                        <td class="text-danger fw-bold">({{ number_format($row['deductions'] ?? 0, 2) }})</td>
                        
                        <td class="bg-info-subtle fw-bolder">{{ number_format($row['net_salary'] ?? 0, 2) }}</td>
                        
                        <td class="bg-light">{{ number_format($row['total_cost'] ?? 0, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                
                <tfoot>
                    <tr class="table-success fw-bolder fs-6">
                        <td class="text-center">الإجمالي الكلي:</td>
                        <td>{{ number_format($totals['basic_salary'] ?? 0, 2) }}</td>
                        <td>{{ number_format($totals['additions'] ?? 0, 2) }}</td>
                        <td>{{ number_format($totals['gross_salary'] ?? 0, 2) }}</td>
                        <td>({{ number_format($totals['deductions'] ?? 0, 2) }})</td>
                        <td>{{ number_format($totals['net_salary'] ?? 0, 2) }}</td>
                        <td>{{ number_format($totals['total_cost'] ?? 0, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>