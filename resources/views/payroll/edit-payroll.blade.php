<x-header />

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold text-warning mb-2">تعديل ملخص كشف الراتب</h2>
                <p class="lead text-muted">للفترة: {{ $payroll->month }}/{{ $payroll->year }}</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-warning bg-gradient text-dark p-3">
                    <h5 class="mb-0 fw-bold"><i class='bx bxs-edit me-2'></i> تعديل البيانات الأساسية</h5>
                </div>
                <div class="card-body p-4">
                    
                    {{-- نموذج التعديل: نستخدم متود PUT/PATCH للتحديث --}}
                    <form action="{{ route('payroll.update', $payroll->id) }}" method="POST">
                        @csrf
                        @method('put')
                        
                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label for="employee_id" class="form-label fw-bold">الموظف</label>
                                <select name="employee_id" id="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="month" class="form-label fw-bold">الشهر</label>
                                <input type="number" name="month" id="month" class="form-control @error('month') is-invalid @enderror" 
                                       value="{{ old('month', $payroll->month) }}" min="1" max="12" required>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="year" class="form-label fw-bold">السنة</label>
                                <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" 
                                       value="{{ old('year', $payroll->year) }}" min="2000" required>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="basic_salary_snapshot" class="form-label fw-bold">الراتب الأساسي (Snapshot)</label>
                                <div class="input-group">
                                    <input type="number" name="basic_salary_snapshot" id="basic_salary_snapshot" class="form-control @error('basic_salary_snapshot') is-invalid @enderror" 
                                           value="{{ old('basic_salary_snapshot', number_format($payroll->basic_salary_snapshot, 2, '.', '')) }}" step="0.01" required placeholder="50000.00">
                                    <span class="input-group-text">USD</span>
                                </div>
                                @error('basic_salary_snapshot')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">تعديل هذه القيمة سيؤدي إلى إعادة حساب صافي الراتب.</small>
                            </div>

                            <div class="col-md-6">
                                <label for="payment_status" class="form-label fw-bold">حالة الدفع</label>
                                <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                    <option value="Pending" {{ old('payment_status', $payroll->payment_status) == 'Pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="Paid" {{ old('payment_status', $payroll->payment_status) == 'Paid' ? 'selected' : '' }}>مدفوع</option>
                                    <option value="Failed" {{ old('payment_status', $payroll->payment_status) == 'Failed' ? 'selected' : '' }}>فشل</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="payment_date" class="form-label fw-bold">تاريخ الدفع الفعلي</label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control @error('payment_date') is-invalid @enderror" 
                                       value="{{ old('payment_date',  $payroll->payment_date->format('Y-m-d') )}}">
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid mt-4 gap-2">
                            <button type="submit" class="btn btn-warning btn-lg rounded-pill">
                                <i class='bx bxs-save me-2'></i> حفظ التعديلات
                            </button>
                            <a href="{{ route('payroll.index') }}" class="btn btn-outline-secondary rounded-pill">إلغاء والعودة</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
    /* إضافة الـ gradient الخاص بـ Warning ليتناسب مع التصميم العصري */
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    }
    .card-header {
        border-bottom: none !important;
    }
</style>    