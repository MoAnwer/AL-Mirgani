<x-header title="قائمة كشوف الرواتب المُعالَجة"/>

<x-layout-wrapper>
    <x-layout-container>
        <x-aside />
        <x-layout-page>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                    <h3 class="mb-10">قائمة كشوف الرواتب المُعالَجة</h3>
                        <x-alert type="message" />
                        <div class="card shadow mb-4">
                            <div class="card-header border-bottom py-4">
                                <h5 class="mb-0">فلاتر البحث</h5>
                            </div>
                            <div class="card-body mt-5">
                                <form method="GET" action="{{ route('payroll.index') }}">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label for="employee_id" class="form-label">الموظف</label>
                                            <select name="employee_id" onchange="this.form.submit()" id="employee_id" class="form-select">
                                                <option value="">-- كل الموظفين --</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="payment_status" class="form-label">حالة الدفع</label>
                                            <select name="payment_status" onchange="this.form.submit()" id="payment_status" class="form-select">
                                                <option value="{{ null }}">-- كل الحالات --</option>
                                                <option value="Paid" @selected(request('payment_status') == 'Paid')>مدفوع</option>
                                                <option value="Pending" @selected(request('payment_status') == 'Pending')>في الانتظار</option>
                                                <option value="Failed" @selected(request('payment_status') == 'Failed')>فشل</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="month" class="form-label">الشهر</label>
                                            <input type="number" onchange="this.form.submit()" name="month" id="month" class="form-control" value="{{ request('month') }}" min="1" max="12">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="year" class="form-label">السنة</label>
                                            <input type="number" onchange="this.form.submit()" name="year" id="year" class="form-control" value="{{ request('year') }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary w-100">بحث</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card shadow">
                            <div class="card-body p-0">
                                    <x-table.basic-table>
                                        <x-table.thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>الموظف</th>
                                                <th>الفترة</th>
                                                <th>الراتب الأساسي</th>
                                                <th>إجمالي المستحقات</th>
                                                <th>إجمالي الاستقطاعات</th>
                                                <th>صافي المبلغ المدفوع</th>
                                                <th>حالة الدفع</th>
                                                <th>تاريخ الدفع</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                        </x-table.thead>
                                        <x-table.tbody>
                                            @forelse ($payrolls as $payroll)
                                                <tr class="text-center">
                                                    <td>{{ $payroll->id }}</td>
                                                    <td class="text-start fw-bold">{{ $payroll->employee->full_name ?? 'موظف محذوف' }}</td>
                                                    <td>{{ $payroll->month }}/{{ $payroll->year }}</td>
                                                    <td>{{ number_format($payroll->basic_salary_snapshot, 2) }} جنية</td>
                                                    <td>
                                                        {{ number_format($payroll->basic_salary_snapshot + $payroll->total_fixed_allowances + $payroll->total_variable_additions, 2) }} جنية
                                                    </td>
                                                    <td class="text-danger">({{ number_format($payroll->total_deductions, 2) }} جنية) </td>
                                                    <td class="fw-bolder text-primary">{{ number_format($payroll->net_salary_paid, 2) }} جنية</td>
                                                    <td>
                                                        @if ($payroll->payment_status == 'Paid')
                                                            <span class="badge bg-success-subtle text-success border border-success rounded">
                                                                <i class="bx bxs-check-circle"></i>
                                                                مدفوع
                                                            </span>
                                                        @elseif ($payroll->payment_status == 'Pending')
                                                            <span class="badge bg-warning-subtle text-warning border border-warning rounded">
                                                                <i class="bx bxs-time"></i>
                                                                قيد الانتظار
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger-subtle text-danger border border-danger rounded"> <i class='bx bxs-x-circle me-1'></i> فشل</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($payroll->payment_date)
                                                        {{ $payroll->payment_date->format('Y-m-d') }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                            <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                             <a class="dropdown-item" href="{{ route('payroll.show', $payroll->id) }}" class="btn btn-sm btn-info">
                                                                <i class='bx bx-news me-1 text-info'></i>
                                                                 عرض
                                                            </a>

                                                            @if ($payroll->payment_status == \App\Enums\PaymentStatusEnum::PENDING->value || $payroll->payment_status == \App\Enums\PaymentStatusEnum::FAILED->value)
                                                                <a class="dropdown-item" href="{{ route('payroll.edit', $payroll->id) }}" class="btn btn-sm btn-warning me-1"> <i class='bx bxs-edit-alt me-1 text-success'></i> تعديل</a>
                                                                <a class="dropdown-item" href="{{ route('payroll.delete', $payroll) }}" class="btn btn-sm btn-warning me-1"> <i class='bx bxs-trash me-1 text-danger'></i>@lang('app.delete')</a>
                                                            @endif

                                                            @if($payroll->payment_status == \App\Enums\PaymentStatusEnum::PAID->value)
                                                                <a class="dropdown-item" href="{{ route('payroll.invoice.print', $payroll) }}" class="btn btn-sm btn-warning me-1"><i class='bx bxs-printer me-1 text-primary'></i> طباعة</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center text-muted py-4">
                                                        لم يتم العثور على أي كشوف رواتب مطابقة لفلتر البحث.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </x-table.tbody>
                                        <tfoot class="bg-label-secondary text-light">
                                            <tr class="text-light text-center fw-bold">
                                                <td></td>
                                                <td class="text-center" colspan="2">الاجمالي</td>
                                                <td>{{ number_format($payrolls->sum('basic_salary_snapshot'), 2) }} جنية</td>
                                                <td>{{ number_format(
                                                    $payrolls->sum('basic_salary_snapshot') + 
                                                    $payrolls->sum('total_fixed_allowances') +
                                                    $payrolls->sum('total_variable_additions')
                                                    , 2) }} جنية</td>
                                                <td>{{ number_format($payrolls->sum('total_deductions'), 2) }} جنية</td>
                                                <td>{{ number_format($payrolls->sum('net_salary_paid'), 2) }} جنية</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </x-table.basic-table>
                                </div>                        
                            <div class="card-footer">
                                {{ $payrolls->withQueryString()->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                </x-container>
            </x-content-wrapper>
        </x-layout-page>
    </x-layout-container>
</x-layout-wrapper>
<x-footer/> 