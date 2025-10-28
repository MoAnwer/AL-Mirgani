<x-header />

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <div class="text-center mb-4">
                <h2 class="text-warning">تعديل بند تفصيلي</h2>
                <p class="lead">
                    كشف راتب: <strong class="text-dark">{{ $payroll->employee->name }}</strong> | 
                    البند الحالي: <strong class="text-dark">{{ $detail->item->name }}</strong>
                </p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-warning bg-gradient text-dark p-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bxs-edit me-2'></i> تعديل قيمة البند</h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- نموذج التعديل: نستخدم متود PUT/PATCH للتحديث --}}
                    <form action="{{ route('payroll.details.update', ['payroll' => $payroll->id, 'detail' => $detail->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">اسم البند (لا يمكن تغييره)</label>
                            <input type="text" class="form-control" value="{{ $detail->item->name }} ({{ $detail->item->type }})" disabled>
                            <input type="hidden" name="item_id" value="{{ $detail->item_id }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-bold">المبلغ الجديد</label>
                            <div class="input-group">
                                <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                                       value="{{ old('amount', number_format($detail->amount, 2, '.', '')) }}" step="0.01" required placeholder="500.00">
                                <span class="input-group-text">USD</span>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">ملاحظات (اختياري)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="تغيير سبب التعديل أو الملاحظات">{{ old('notes', $detail->notes) }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg rounded-pill">
                                <i class='bx bxs-save me-2'></i> حفظ التعديل وتحديث الكشف
                            </button>
                            <a href="{{ route('payroll.show', $payroll->id) }}" class="btn btn-outline-secondary rounded-pill">
                                <i class='bx bx-undo me-2'></i> إلغاء والعودة للكشف
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>