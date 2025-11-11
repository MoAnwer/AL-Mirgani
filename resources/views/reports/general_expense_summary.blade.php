<x-header title="{{ __('app.general_expense_report') }}" />

    <style>
        .card-expense {
            border-right: 5px solid #dc3545; 
        }

    </style>



<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="container-fluid py-3">
                    <div class="card -sm border-0 mb-5">
                        <div class="card-body p-4 p-md-5">
                            <header class="mb-4 border-bottom pb-3">
                                <h1 class="h3 fw-bold text-dark">تقرير إجمالي المصروفات العامة للمدرسة</h1>
                                <p class="text-muted">الإجمالي الكلي للمصروفات التشغيلية والمدرسية بناءً على الفلاتر المحددة.</p>
                            </header>

                            
                            <div class="p-3  border -sm rounded-3 mb-5">
                                <div class="card-header border-bottom pt-1 pb-3 mb-5">
                                    <h5 class="mb-0">{{ __('app.filters') }}</h5>
                                </div>
                                <form action="{{ url()->current() }}" method="GET" class="row g-3 align-items-end  pb-3">
                                    
                                    <div class="col-md-3 col-sm-6">
                                        <label for="school_id" class="form-label text-dark fw-medium pb-1">المدرسة</label>
                                        <select name="school_id" id="school_id" class="form-select" onchange="this.form.submit()">
                                            <option value="">جميع المدارس</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}" @selected(request('school_id') == $school->id)>{{ $school->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 col-sm-6">
                                        <label for="start_date" class="form-label text-dark fw-medium pb-1">تاريخ البداية</label>
                                        <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" onchange="this.form.submit()"
                                            class="form-control">
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-6">
                                        <label for="end_date" class="form-label text-dark fw-medium pb-1">تاريخ النهاية</label>
                                        <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" onchange="this.form.submit()"
                                            class="form-control">
                                    </div>

                                     <div class="col-3">
                                        <label class="form-label text-dark fw-medium pb-1">@lang('app.the_category')</label>
                                        <select class="form-select" name="category_id" onchange="this.form.submit()">
                                        <option value="{{ null }}" selected></option>
                                            @foreach($categories as $key => $value)
                                                <option value="{{ $value }}" @selected(request()->query('category_id') == $value)>{{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>

                            <div class="card shadow-0 card-expense border border-danger p-5">
                                <div class="card-body p-4 ">
                                    <h2 class="h5 text-dark mb-3">الإجمالي الكلي للمصروفات التشغيلية في الفترة المحددة</h2>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="display-5 fw-bolder text-danger mb-0">
                                            {{ $reportData['total_amount'] }} جنية
                                        </p>
                                        <i class="bx bx-dollar text-danger opacity-50" style="font-size: 3rem;"></i>
                                    </div>
                                    <p class="text-secondary mt-3 mb-0">
                                        هذا المبلغ يمثل مجموع جميع المصروفات المُسجلة والتي استوفت شروط البحث.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />