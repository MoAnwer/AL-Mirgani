<li class="menu-item {{ request()->is($route) ? 'active' : '' }}" >
    <a 
        @isset($route) 
            href="{{ route($route)}} 
        @endisset" 
        class="menu-link {{ $classes }}"
    >
    @isset($icon)
        <i class="menu-icon {{ $icon }}"></i> 
    @endisset

        <div class="text-truncate">{{$label}}</div>

    </a>

    {{ $slot }}
    
</li>
