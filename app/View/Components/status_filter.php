<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class status_filter extends Component
{
    public $statuses;
    public $targetTable;
    public $activeColor;

    /**
     * Create a new component instance.
     */
    public function __construct($statuses = [], $targetTable = '', $activeColor = 'bg-lime-400 text-white')
    {
        $this->statuses = $statuses;
        $this->targetTable = $targetTable;
        $this->activeColor = $activeColor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.status_filter');
    }
}
