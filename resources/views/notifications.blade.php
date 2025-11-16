<x-header title="{{ __('app.notifications') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .notification-card {
            border-right: 3px solid var(--bs-primary);
            border-radius: 0.2rem; 
            transition: all 0.3s ease-in-out;
        }
        .notification-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        .icon-circle {
            border-radius: 55%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0; 
        }
        .btn-mark-read {
            border-radius: 0.5rem;
        }
        .pagination .page-item .page-link {
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            color: var(--bs-primary);
        }
        .pagination .page-item.active .page-link {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: white;
        }
    </style>
<x-LayoutWrapper>
    <x-LayoutContainer>
        <x-aside />
        <x-LayoutPage>
            <x-nav />
            <x-ContentWrapper>
                <x-Container>


        <div class="justify-content-center card p-10">
            <div class="col-lg-12 col-md-12">

                <header class="mb-1 pb-3 border-secondary">
                    <h1 class="display-6 fw-bold text-dark d-flex align-items-center">
                        <i class="bx bxs-bell text-primary me-2 fs-4"></i>
                        {{ __('app.unread_notifications') }}
                    </h1>
                    <p class="text-muted mt-1">@lang('app.flow_your_latest_new')</p>
                </header>


                <hr class="mb-8"/>

                <div class="d-grid gap-2">
                    @forelse ($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $color = $data['color'] ?? 'primary'; 
                            $icon = $data['icon'] ?? 'bx bxs-info-circle';
                            $title = $data['title'] ?? __('app.new_notification');
                            $body = $data['message'] ?? __('app.no_notification_text');
                        @endphp

                        <div id="notification-{{ $notification->id }}" 
                             class="notification-card  p-3 shadow-sm border-{{ $color }}"
                             style="--bs-primary: {{ $color === 'primary' ? '#0d6efd' : ($color === 'success' ? '#198754' : ($color === 'danger' ? '#dc3545' : '#ffc107')) }};">
                            
                            <div class="d-flex justify-content-between align-items-start">
                                
                                <div class="d-flex align-items-start flex-grow-1 me-3">
                                    <div class="me-3 mt-1 badge bg-{{ $color }}-subtle text-{{ $color }} border border-{{ $color }} py-2 rounded-pill icon-circle">
                                        <i class="{{ $icon }} fs-5"></i>
                                    </div>
                                    <div>
                                        <h3 class="h5 fw-bold text-dark mb-1">{{ $title }}</h3>
                                        <p class="text-secondary small mb-2">{{ $body }}</p>
                                        <small class="text-muted">
                                            <i class="bx bx-time me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>

                                <div class="flex-shrink-0">
                                    <button 
                                        data-id="{{ $notification->id }}"
                                        class="mark-as-read-btn bg-white border-0 text-secondary"
                                        title="{{ __('app.mark_as_read') }}">
                                        <i class="bx bx-check-double small"></i>
                                        @lang('app.mark_as_read')
                                    </button>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="card p-5 shadow-sm text-center border-0">
                            <i class="bx bx-search text-secondary display-4 mb-3"></i>
                            <h3 class="h4 fw-semibold text-dark">@lang('app.no_unread_header')</h3>
                            <p class="text-muted mt-2">@lang('app.no_unread_body')</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.mark-as-read-btn');            
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-id');
                    const card = document.getElementById(`notification-${notificationId}`);
                    this.disabled = true;
                    this.innerHTML = '<i class="bx bx-loader-alt bx-spin small"></i>'; 
                    fetch(`/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '',
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            if (card) {
                                card.style.opacity = '0';
                                card.style.transform = 'translateY(50%)';
                                setTimeout(() => {
                                    card.remove();
                                    const remainingCards = document.querySelectorAll('.notification-card').length;
                                    if (remainingCards === 0) {
                                        // window.location.reload(); 
                                    }
                                }, 500);
                            }

                        } else {
                            alert("Error");
                            this.disabled = false;
                            this.innerHTML = '<i class="bx bx-check small"></i>'; 
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error')
                        this.disabled = false;
                        this.innerHTML = '<i class="bx bx-check small"></i>'; 
                    });
                });
            });
        });
    </script>
            </x-Container>
            </x-ContentWrapper>
        </x-LayoutPage>
    </x-LayoutContainer>
</x-LayoutWrapper>
<x-footer/> 
