<x-header title="payroll"/>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="text-center text-info mb-4">معالجة كشف راتب: {{ $employee->name }}</h2>
            <p class="text-center lead">شهر: {{ $month }} / {{ $year }}</p>

            <form action="{{ route('payroll.store') }}" method="POST">
                @csrf
                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">

                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        تفاصيل الراتب الأساسية والتحضير
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="fw-bold">الراتب الأساسي:</label>
                                <p class="text-muted">{{ number_format($employee->basic_salary, 2) }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold text-success">العلاوات الثابتة:</label>
                                <p class="text-success">{{ number_format($employee->fixed_allowances, 2) }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold text-danger">استقطاعات إلزامية (تأمينات):</label>
                                <p class="text-danger">({{ number_format($compulsoryDeduction, 2) }})</p>
                            </div>
                        </div>
                        <hr>
                        <h5 class="text-secondary">إجمالي المستحقات الأساسية: {{ number_format($grossBaseSalary, 2) }}</h5>
                    </div>
                </div>

                {{-- **جزء المعالجة: إدخال الحركات المتغيرة** --}}
                <div class="card mt-4">
                    <div class="card-header bg-warning text-dark fw-bold">
                        إدخال الحركات المتغيرة لهذا الشهر (المعالجة)
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- إضافات متغيرة --}}
                            <div class="col-md-6 mb-3">
                                <label for="variable_additions" class="form-label text-success fw-bold">إضافات متغيرة (مثل عمل إضافي، مكافآت)</label>
                                <input type="number" name="variable_additions" id="variable_additions" class="form-control" 
                                       value="{{ old('variable_additions', 0) }}" step="0.01">
                            </div>

                            {{-- استقطاعات متغيرة --}}
                            <div class="col-md-6 mb-3">
                                <label for="variable_deductions" class="form-label text-danger fw-bold">استقطاعات متغيرة (مثل سلف، خصم غياب)</label>
                                <input type="number" name="variable_deductions" id="variable_deductions" class="form-control" 
                                       value="{{ old('variable_deductions', 0) }}" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- **جزء التسجيل: حالة الدفع** --}}
                <div class="card mt-4">
                    <div class="card-header bg-success text-white">
                        حالة الدفع والتسجيل
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="payment_status" class="form-label fw-bold">حالة الدفع النهائية</label>
                            <select name="payment_status" id="payment_status" class="form-control" required>
                                <option value="Pending">قيد الانتظار</option>
                                <option value="Paid" selected>مدفوع الآن</option>
                                <option value="Failed">فشل الدفع</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fs-5 mt-3">حساب وتأكيد كشف الراتب (التسجيل النهائي)</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>