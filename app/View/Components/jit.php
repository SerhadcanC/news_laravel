<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class jit extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        echo (function_exists('opcache_get_status') 
            && opcache_get_status()['jit']['enabled']) ? 'JIT enabled' : 'JIT disabled';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.jit');
    }
}
