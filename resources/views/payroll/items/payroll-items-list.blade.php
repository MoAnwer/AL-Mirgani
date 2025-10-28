<x-header title="قائمة عناصر الرواتب"/>
<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                    <h4 class="mb-4">
                        قائمة عناصر الرواتب
                    </h4>
                    <div class="card">
                    <div class="card-body my-5 px-0">
                    <div class="row px-0">
                        <div>
                            <div class="d-flex justify-content-end mb-3 mx-5">
                                <a href="{{ route('payroll_items.create') }}" class="btn btn-success">
                                    <i class="bx bx-plus-circle"></i>
                                    <span class="mx-2"> إضافة عنصر جديد</span>
                                </a>
                            </div>
                            <x-table.basic-table>
                                <x-table.thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">اسم العنصر</th>
                                        <th class="text-center">النوع</th>
                                        <th class="text-center">هل هو ثابت؟</th>
                                        <th class="text-center">القيمة الافتراضية</th>
                                        <th class="text-center">تاريخ الإنشاء</th>
                                        <th class="text-center">@lang('app.actions')</th>
                                    </tr>
                                </x-table.thead>
                                <x-table.tbody>
                                    @forelse ($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td class="text-center fw-bold">{{ $item->name }}</td>
                                        <td class="text-center">
                                            @if ($item->type == 'Addition' || $item->type == 'Benefit')
                                                <span class="badge text-black bg-label-success">{{ $item->type == 'Addition' ? 'إضافة/علاوة' : 'منفعة' }}</span>
                                            @elseif ($item->type == 'Deduction' || $item->type == 'Tax')
                                                <span class="badge bg-label-danger">{{ $item->type == 'Deduction' ? 'استقطاع/خصم' : 'ضريبة' }}</span>
                                            @else
                                                {{ $item->type }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->is_fixed)
                                                <span class="badge bg-label-info text-dark">نعم</span>
                                            @else
                                                <span class="badge bg-secondary">لا (متغير)</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->default_value > 0)
                                                {{ number_format($item->default_value, 2) }}
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->created_at->format('Y-m-d')}} ({{ $item->created_at->diffForHumans()  }})</td>
                                        <td>
                                                <div class="dropdown text-center">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('payroll_items.edit', $item) }}"><i class="icon-base text-success bx bx-edit-alt me-1"></i>@lang('app.edit')</a>
                                                        {{-- <a class="dropdown-item" href="{{ route('payroll_items.delete', $item) }}"><i class="icon-base text-danger bx bx-trash me-1"></i>@lang('app.delete')</a> --}}
                                                    </div>
                                                </div>
                                            </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                لا توجد عناصر رواتب مسجلة حتى الآن. ابدأ بإضافة عنصر جديد!
                                            </td>
                                        </tr>
                                    @endforelse
                                    @section('pagination')
                                        <div class="mt-5 px-5">{{ $items->withQueryString()->links('vendor.pagination.bootstrap-5') }} </div>
                                    @endsection
                                </x-table.tbody>
                            </x-table.basic-table>
                        </div>
                    </div>
                </div>
                </div>
                </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer />