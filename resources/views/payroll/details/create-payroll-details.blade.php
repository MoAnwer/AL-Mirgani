<x-header title="إضافة بند جديد لكشف الراتب"/>

<x-layout-wrapper>
    <x-layout-container>
        <x-aside />
        <x-layout-page>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                <x-alert type="message" />
                <x-alert type="error" />
                <div class="row justify-content-center">
                        <h3 >إضافة بند جديد لكشف الراتب</h3  >
                        <div class="col-md-12">
                            <div class="text-center mb-4">
                                <p class="lead">
                                    للموظف: <strong class="text-dark">{{ $payroll->employee->full_name }}</strong> | 
                                    الفترة: <strong class="text-dark">{{ $payroll->month }}/{{ $payroll->year }}</strong>
                                </p>
                            </div>

                            <div class="card shadow-lg">
                                <div class="card-body p-4">
                                    <form action="{{ route('payroll.details.store', $payroll->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="item_id" class="form-label fw-bold">اختر البند (إضافة أو استقطاع)</label>
                                            <select name="item_id" id="item_id" class="form-select @error('item_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>-- اختر من قائمة العناصر --</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }} ({{ $item->type }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('item_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="amount" class="form-label fw-bold">المبلغ</label>
                                            <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                                value="{{ old('amount') }}" step="0.01" required placeholder="e.g., 500.00">
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="notes" class="form-label">ملاحظات (اختياري)</label>
                                            <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="e.g., Overtime hours for project X">{{ old('notes') }}</textarea>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-info btn-lg">إضافة البند وتحديث الكشف</button>
                                        </div>
                                    </form>
                                    
                                </div>
                                <div class="card-footer text-center">
                                    <a href="{{ route('payroll.show', $payroll->id) }}" class="btn btn-secondary btn-sm">إلغاء والعودة للكشف</a>
                                </div>
                            </div>
                        </div>

                </x-container>
            </x-content-wrapper>
        </x-layout-page>
    </x-layout-container>
</x-layout-wrapper>
<x-footer/> 