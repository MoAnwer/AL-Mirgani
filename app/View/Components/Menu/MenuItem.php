<?php

namespace App\View\Components\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $route,
        public ?string $label,
        public ?string $icon,
        public ?string $classes
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.menu-item');
    }
}
