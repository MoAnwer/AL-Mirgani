<x-header title="إنشاء عنصر راتب جديد"/>



<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-container>
                    <h4 class="mb-0">إنشاء عنصر راتب جديد</h4>
                    <div class="container my-5">
                        <x-alert type="message" />

                        <div class="card p-5">
                            <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-7">
                                    <div class="form">
                                        <div class="content">
                                            
                                            {{-- Form Start --}}
                                            <form action="{{ route('payroll_items.store') }}" method="POST">
                                                @csrf
                                                
                                                {{-- اسم العنصر --}}
                                                <div class="mb-5">
                                                    <label for="name" class="form-label fw-bold">اسم العنصر (مثال: بدل لبس، غرامة غياب)</label>
                                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                                        value="{{ old('name') }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                {{-- نوع العنصر --}}
                                                <div class="mb-5">
                                                    <label for="type" class="form-label fw-bold">نوع الحركة</label>
                                                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                                        <option value="" disabled selected>-- اختر النوع --</option>
                                                        @foreach ($itemTypes as $type)
                                                            <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
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
                                                <div class="form-check mb-5">
                                                    <input class="form-check-input" type="checkbox" name="is_fixed" id="is_fixed" value="1" {{ old('is_fixed') ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold" for="is_fixed">
                                                        هل هذا العنصر ثابت القيمة شهرياً؟ (مثل بدل النقل)
                                                    </label>
                                                </div>

                                                {{-- القيمة الافتراضية --}}
                                                <div class="mb-5">
                                                    <label for="default_value" class="form-label">القيمة الافتراضية (تُستخدم إذا كان العنصر ثابتاً)</label>
                                                    <input type="number" name="default_value" id="default_value" class="form-control @error('default_value') is-invalid @enderror" 
                                                        value="{{ old('default_value', 0) }}" step="0.01">
                                                    @error('default_value')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <button type="submit" class="btn btn-success w-100 mt-3">حفظ العنصر المالي</button>
                                            </form>
                                            {{-- Form End --}}

                                        </div>
                                    </div>
                                </div>
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