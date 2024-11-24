<?php

namespace App\View\Components\modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class flowbiteModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $modalID,
        public string $width
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.flowbite-modal');
    }
}