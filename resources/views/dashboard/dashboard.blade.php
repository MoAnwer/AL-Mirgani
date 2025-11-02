<x-header title="{{ $title }}">
    @section('charts-css')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css')}}"/>
    @stop
</x-header>
    <x-LayoutWrapper>
      <x-LayoutContainer>
        <x-aside />
          <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper >
              <x-container>
                <div class="row">
                <div class="col-xxl-12 mb-6 order-0">
                  <div class="card">
                    <div class="d-flex align-items-center row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h4 class="card-title text-primary mb-3">مرحبا {{ auth()->user()->name }}  !  لنستعرض آخر الإنجازات. 🎉</h4>
                          <p>ملخص مالي دقيق وقائمة محدّثة بآخر المنضمين إلينا. أنت على اطلاع دائم.<p>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                          <img
                            src="../assets/img/illustrations/man-with-laptop.png"
                            height="175"
                            alt="View Badge User" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-6 col-6 col-md-12 col-12 order-3 order-md-2 profile-report">
                  <div class="row">
                    
                    <div class="col-4 mb-6 payments">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img src="../assets/img/icons/unicons/paypal.png" alt="paypal" class="rounded" />
                            </div>
                          </div>
                          <p class="mb-1">المنصرفات</p>
                          <h4 class="card-title mb-3">{{ $totalExpenses }}</h4>
                          <small class="text-danger fw-medium"
                            ><i class="icon-base bx bx-{{ $totalExpenses > $totalProfit ?  'up' : 'down' }}-arrow-alt"></i>{{ $totalExpenses }}</small
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../assets/img/icons/unicons/chart-success.png"
                                alt="chart success"
                                class="rounded" />
                            </div>
                          </div>
                          <p class="mb-1">الارباح</p>
                          <h4 class="card-title mb-3">{{ $totalProfit }}</h4>
                          <small class="text-{{ $totalProfit > $totalExpenses ? 'success' : 'danger'  }} fw-medium">
                            <i class="icon-base bx bx-{{ $totalProfit > $totalExpenses ? 'up' : 'down'  }}-arrow-alt"></i> {{ $totalProfit }}</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-6 transactions">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                            </div>
                          </div>
                          <p class="mb-1">@lang('app.the_earnings')</p>
                          <h4 class="card-title mb-3">{{ $totalRevenue }}</h4>
                          <small class="text-success fw-medium"><i class="icon-base bx bx-up-arrow-alt"></i> {{ $totalRevenue }}</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-4 col-sm-12 col-xl-4 order-0 mb-6">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">منصرفات الاسبوع الحالي</h5>
                      <p class="card-subtitle">{{ $totalExpenses }}</p>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex flex-column align-items-center gap-1">
                          <h3 class="mb-1">{{ $totalExpenses }}</h3>
                          <small> اجمالي المنصرفات </small>
                        </div>
                      </div>
                      <ul class="p-0 m-0">
                        

                          @foreach ($expenseCategories as $category)
                          <li class="d-flex align-items-center mb-5">
                           <div class="avatar flex-shrink-0 me-3">
                              <span class="avatar-initial rounded bg-label-primary">
                                <i class="icon-base bx bx-mobile-alt"></i>
                              </span>
                            </div>
                             <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-0">{{ $category->name ?? 0 }}</h6>
                              </div>
                              <div class="user-progress">
                                <h6 class="mb-0">{{ $category->expenses->sum('amount') }}</h6>
                              </div>
                            </div>
                          </li>
                          @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
                <!--/ Order Statistics -->

                <!-- Transactions -->
                <div class="col-md-6 col-lg-8 order-2 mb-6">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">احدث التلاميذ بالنظام</h5>
                    </div>

                  <div class="card-body pt-4">
                    <ul class="p-0 m-0">
                    @foreach ($latestStudents as $student)
                        <li class="d-flex align-items-center mb-6">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="../assets/img/icons/unicons/paypal.png" alt="User" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="fw-normal mb-0">{{ $student->full_name }}</h6>
                              <small class="d-block">{{ $student->stage }}</small>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                              <h6 class="fw-normal mb-0">{{ $student->formatted_created_at  }}</h6>
                            </div>
                          </div>
                        </li>
                    @endforeach
                      </ul>
                    </div>
                    </div>
                  </div>
                </div>
                <!--/ Transactions -->
                </div>
              </x-container>
            <div class="content-backdrop fade"></div>
            </x-ContentWrapper >
          </x-LayoutPage>
      </x-LayoutContainer>
        <div class="layout-overlay layout-menu-toggle"></div>
    </x-LayoutWrapper>
<x-footer />