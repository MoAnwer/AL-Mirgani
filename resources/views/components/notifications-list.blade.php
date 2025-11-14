<div class="offcanvas offcanvas-end px-1 justify-content-start" tabindex="-1" id="offcanvasBackdrop" aria-labelledby="offcanvasBackdropLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasBackdropLabel" class="offcanvas-title">{{ __('app.notifications') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body my-auto mx-0 flex-grow-0 shadow-0 p-3">
            <div id="accordionIcon" class="shadow-0 accordion mt-4 accordion-without-arrow shadow-none">
                @forelse (auth()->user()->unreadNotifications()->take(10)->latest()->get() as $notification)
                <div class="shadow-none border accordion-item">
                    <h2 class="shadow-0 accordion-header text-body d-flex justify-content-between shadow-0 mb-2" id="accordionIconThree">
                        <span class="rounded-pill text-primary flex-start mt-4 mx-3 fs-5">
                            <i class="bx bx-bell"></i>
                        </span>
                        <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="{{ '#accordionIcon-'.$loop->iteration }}" aria-expanded="true" aria-controls="accordionIcon-{{ $loop->iteration }}">
                            {{ $notification->data['title'] }}
                        </button>
                    </h2>
                    <div id="accordionIcon-{{ $loop->iteration }}" class="accordion-collapse collapse shadow-0" data-bs-parent="#accordionIcon">
                        <div class="shadow-0 accordion-body shadow-0 ps-10">
                            {{ $notification->data['message'] }}
                        </div>
                    </div>
                </div>
                @empty

                @endforelse
            </div>

        </div>
    </div>
</div>
