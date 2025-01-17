<?php

namespace App\View\Components\tables;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class table extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Array $headers,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tables.table');
    }
}
