<li class="nav-item navbar-dropdown dropdown-user dropdown">
    <a
    class="nav-link dropdown-toggle hide-arrow p-0"
    href="javascript:void(0);"
    data-bs-toggle="dropdown">
    <div class="avatar avatar-online">
        <img src="{{ asset('assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
    </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
    <li>
        <a class="dropdown-item" href="#">
        <div class="d-flex">
            <div class="flex-shrink-0 me-3">
            <div class="avatar avatar-online">
                <img src="{{ asset('assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
            </div>
            </div>
            <div class="flex-grow-1">
            <h6 class="mb-0">{{ $name }}</h6>
            <small class="text-body-secondary">{{ $username }}</small>
            </div>
        </div>
        </a>
    </li>
    <li>
        <div class="dropdown-divider my-1"></div>
    </li>
    <li>
        <a class="dropdown-item" href="{{ route('settings.page') }}">
        <i class="icon-base bx bx-cog icon-md me-3"></i><span>{{ __('app.settings') }}</span>
        </a>
    </li>
    <li>
        <a class="dropdown-item" href="{{ route('notifications.index') }}">
        <span class="d-flex align-items-center align-middle">
            <i class="flex-shrink-0  icon-md me-3 bx bx-bell"></i><span class="flex-grow-1 align-middle">{{ __('app.notifications') }}</span>
        </span>
        </a>
    </li>
    <li>
        <div class="dropdown-divider my-1"></div>
    </li>
    <form action="{{ route('auth.logout') }}" method="POST">
    @csrf
    <li>
        <button class="dropdown-item" type="submit">
        <i class="icon-base bx bx-power-off icon-md me-3"></i><span>{{ __('auth.logout') }}</span>
        </button>
    </li>
    </form>
    </ul>
</li>