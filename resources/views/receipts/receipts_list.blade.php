<x-header title="{{ __('app.receipts_list') }}">
    @section('charts-css')
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/receipts.css') }}" />
    @stop
</x-header>

<x-layout-wrapper>
    <x-layout-container>
        <x-aside />
        <x-layout-page>
            <x-nav />
            <x-content-wrapper>
                <x-container>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card card-main">
                                <div class="header-section">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2 class="h4 fw-bold d-flex align-items-center mb-0">
                                            <i class="bx bxs-receipt text-primary me-2 fs-3"></i>
                                            {{ __('app.receipts_list') }}
                                        </h2>

                                        <form method="GET" action="{{ route('receipts.index') }}" class="d-flex" style="min-width: 380px;">
                                            <input type="search" name="search" class="form-control search-input me-3" placeholder="{{ __('app.search_receipt_placeholder') }}" value="{{ request('search') }}" onchange="this.form.submit()">
                                            <button type="submit" class="btn btn-primary d-flex align-items-center rounded-pill px-4">
                                                <i class="bx bx-search-alt me-1"></i> {{ __('app.search') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="px-2">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">{{ __('app.receipt_number') }}</th>
                                                    <th style="width: 15%;">{{ __('app.student') }}</th>
                                                    <th style="width: 15%;" class="text-center">{{ __('app.paid_amount') }}</th>
                                                    <th style="width: 15%;" class="text-center">{{ __('app.payment_date') }}</th>
                                                    <th style="width: 15%;" class="text-center">{{ __('app.issue_date') }}</th>
                                                    <th style="width: 5%;" class="text-center">{{ __('app.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($receipts as $receipt)
                                                <tr class="receipt-row">
                                                    <td><span class="fw-bold text-dark">{{ $receipt->number }}</span></td>
                                                    <td>
                                                        <div class="student-details">
                                                            <i class='bx bxs-user-circle'></i>
                                                            <div>
                                                                <div class="student-name mt-2">{{ $receipt->student->full_name ?? __('app.deleted_student') }}</div>
                                                                <div class="school-id mt-1 fw-medium">{{ $receipt->student->student_number ?? 'N/A' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><span class="amount-paid">{{ number_format($receipt->amount) }} {{ __('app.currency') }}</span></td>
                                                     <td class="text-center">
                                                        @if ($receipt->installmentPayment && $receipt->installmentPayment->payment_date)
                                                        <span class="badge bg-success-subtle text-success border border-success rounded">{{ $receipt->installmentPayment->payment_date }}</span>
                                                        @else
                                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary rounded">{{ __('app.not_specified') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center text-muted">{{ $receipt->created_at->format('Y-m-d') }}</td>
                                                    <td  style="width: 5%;" class="text-center">
                                                        <a class="btn btn-outline-primary" href="{{ route('receipts.show', $receipt->id) }}">
                                                            <i class="bx bx-show-alt me-2"></i>
                                                            {{ __('app.view') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7" class="text-center py-10">
                                                        <i class="bx bx-file-blank text-secondary display-4 mb-3"></i>
                                                        <p class="h5 text-muted">{{ __('app.no_receipts_recorded') }}</p>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4 d-flex justify-content-center">
                                        {{ $receipts->withQueryString()->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-container>
            </x-content-wrapper>
        </x-layout-page>
    </x-layout-container>
</x-layout-wrapper>
<x-footer />
