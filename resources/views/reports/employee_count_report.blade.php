<x-header title="{{ __('app.employee_report') }}" />
<style>
    .card-clean {
        border-radius: 12px;
        border: 1px solid #eef1f6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease-in-out;
    }

    .card-clean:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .card-summary {
        background-color: #ffffff;
        color: #343a40;
    }

    .total-banner {
        background-color: #f0f8ff;
        color: #0d6efd;
        border-left: 5px solid #0d6efd;
    }

    .category-card {
        min-height: 150px;
        display: flex;
        align-items: center;
    }

    .icon-box {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border-radius: 8px;
        padding: 15px;
        font-size: 2rem;
        width: 70px;
        height: 70px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .teacher-color .icon-box {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .administrative-color .icon-box {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    / .worker-color .icon-box {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .other-color .icon-box {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .count-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #343a40;
    }

    .btn-filter {
        background-color: #6f42c1;
        border-color: #6f42c1;
        box-shadow: 0 4px 10px rgba(111, 66, 193, 0.2);
    }

    .btn-filter:hover {
        background-color: #5a35a1;
        border-color: #5a35a1;
    }

</style>

<x-layout-wrapper>
    <x-aside />
    <x-layout-page>
        <x-nav />
        <x-layout-container>
            <x-container>
                <div class="card card-clean border-0">
                    <div class="card-body p-md-5">

                        <header class="mb-5 border-bottom pb-3">
                            <h1 class="h3 fw-bold text-dark">@lang('app.employee_report_heading')</h1>
                            <p class="text-muted">@lang('app.employee_report_bio')</p>
                        </header>


                        <div class="p-4 mb-5 total-banner rounded-3 shadow-sm d-flex justify-content-between align-items-center">
                            <div class="h4 mb-0 fw-bold">
                                <i class='bx bxs-group me-2'></i>@lang('app.employee_report_total_count')
                            </div>
                            <span class="count-number" style="color: #0d6efd;">{{ $grandTotal }}</span>
                        </div>

                        <hr>

                        <div class="row g-4 mb-5">

                            @forelse ($reportData as $data)
                            <div class="col-md-4 col-sm-6">
                                @php
                                $class = $categoryMap[$data['category_key']] ?? $categoryMap['other'];
                                $icon = $iconMap[$data['category_title']] ?? 'bx-question-mark';
                                @endphp
                                <div class="card border card-clean category-card {{ $class }}">
                                    <div class="card-body p-4 w-100 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3">
                                                <i class='bx {{ $icon }}'></i>
                                            </div>
                                            <div>
                                                <p class="text-muted small mb-1">@lang('app.count_of', ['count' => ''])</p>
                                                <h5 class="card-title fw-bold mb-0 text-dark">{{ $data['category_title'] }}</h5>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="count-number">{{ $data['count'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="alert alert-warning" role="alert">
                                    <i class='bx bx-error-alt'></i>@lang('app.empty_message', ['attributes' => __('app.employees')])
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="text-center my-4 no-print">
                    <a href="{{ route('reports') }}" class="btn btn-info btn-lg rounded-pill">
                        <i class='bx bx-arrow-back me-2'></i> @lang('app.back')
                    </a>
                </div>
                </div>
            </x-container>
        </x-layout-container>
    </x-layout-page>
</x-layout-wrapper>
<x-footer />
