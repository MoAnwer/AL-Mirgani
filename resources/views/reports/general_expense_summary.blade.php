<x-header title="تقرير إجمالي المصروفات العامة" />

    <style>
        /* التنسيق الأساسي للعرض من اليمين لليسار */
        body { direction: rtl; }
        .card-expense {
            border-right: 5px solid #dc3545; /* خط أحمر على اليمين */
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>

    <div class="container-fluid py-3">
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4 p-md-5">
                
                <header class="mb-4 border-bottom pb-3">
                    <h1 class="h3 fw-bold text-dark">تقرير إجمالي المصروفات العامة للمدرسة</h1>
                    <p class="text-muted">الإجمالي الكلي للمصروفات التشغيلية والمدرسية بناءً على الفلاتر المحددة.</p>
                </header>

                <div class="p-3 bg-info-subtle border border-info-subtle rounded-3 mb-5">
                    <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end">
                        
                        <div class="col-md-3 col-sm-6">
                            <label for="school_id" class="form-label text-dark fw-medium">المدرسة</label>
                            <select name="school_id" id="school_id" class="form-select" onchange="this.form.submit()">
                                <option value="">جميع المدارس</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" @selected(request('school_id') == $school->id)>{{ $school->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label for="start_date" class="form-label text-dark fw-medium">تاريخ البداية</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" onchange="this.form.submit()"
                                   class="form-control">
                        </div>
                        
                        <div class="col-md-3 col-sm-6">
                            <label for="end_date" class="form-label text-dark fw-medium">تاريخ النهاية</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" onchange="this.form.submit()"
                                   class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="bi bi-search"></i> تطبيق الفلاتر
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card card-expense border border-danger p-5">
                    <div class="card-body p-4">
                        <h2 class="h5 text-dark mb-3">الإجمالي الكلي للمصروفات التشغيلية في الفترة المحددة</h2>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="display-5 fw-bolder text-danger mb-0">
                                 {{ $reportData['total_amount'] }} جنية
                            </p>
                            <i class="bi bi-currency-dollar text-danger opacity-50" style="font-size: 3rem;"></i>
                        </div>
                        <p class="text-secondary mt-3 mb-0">
                            هذا المبلغ يمثل مجموع جميع المصروفات المُسجلة والتي استوفت شروط البحث.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>