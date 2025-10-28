            
<x-header title="قائمة عناصر الرواتب"/>
<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                    <div class="container my-5">
                        <div class="row justify-content-center">
                            <div class="col-md-7">
                                <div class="card shadow-lg">
                                    <div class="card-header bg-warning text-dark">
                                        <h4 class="mb-0">تعديل عنصر الراتب: {{ $item->name }}</h4>
                                    </div>
                                    <div class="card-body">
                                        
                                        {{-- Form Start - استخدام method PUT/PATCH --}}
                                        <form action="{{ route('payroll_items.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT') 
                                            
                                            {{-- اسم العنصر --}}
                                            <div class="mb-3">
                                                <label for="name" class="form-label fw-bold">اسم العنصر (مثال: بدل لبس، غرامة غياب)</label>
                                                {{-- استخدام old() لحفظ القيمة عند وجود أخطاء، وإلا استخدام قيمة العنصر الحالية --}}
                                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                                    value="{{ old('name', $item->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            {{-- نوع العنصر --}}
                                            <div class="mb-3">
                                                <label for="type" class="form-label fw-bold">نوع الحركة</label>
                                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                                    <option value="" disabled>-- اختر النوع --</option>
                                                    @foreach (['Addition', 'Deduction', 'Tax', 'Benefit'] as $type)
                                                        <option value="{{ $type }}" {{ old('type', $item->type) == $type ? 'selected' : '' }}>
                                                            {{ $type == 'Addition' ? 'إضافة/علاوة' : 
                                                            ($type == 'Deduction' ? 'استقطاع/خصم' : 
                                                                ($type == 'Tax' ? 'ضريبة' : 'منفعة/ميزة')) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <hr>
                                            
                                            {{-- هل هو ثابت؟ --}}
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="is_fixed" id="is_fixed" value="1" 
                                                    {{ old('is_fixed', $item->is_fixed) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="is_fixed">
                                                    هل هذا العنصر ثابت القيمة شهرياً؟
                                                </label>
                                            </div>

                                            {{-- القيمة الافتراضية --}}
                                            <div class="mb-3">
                                                <label for="default_value" class="form-label">القيمة الافتراضية</label>
                                                <input type="number" name="default_value" id="default_value" class="form-control @error('default_value') is-invalid @enderror" 
                                                    value="{{ old('default_value', $item->default_value) }}" step="0.01">
                                                @error('default_value')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-warning w-100 mt-3">تحديث العنصر المالي</button>
                                        </form>
                                        {{-- Form End --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </x-container>
        </x-ContentWrapper>
    </x-LayoutPage>
</x-LayoutContainer>
</x-LayoutWrapper>
<x-footer />