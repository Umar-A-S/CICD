<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class statuscard_kakot extends Component
{
    /**
     * Create a new component instance.
     */
    public $stat;

    public function __construct($stat = null)
    {
        $this->stat = $stat;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.statuscard_kakot');
    }
}
