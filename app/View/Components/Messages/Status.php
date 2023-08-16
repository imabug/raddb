<?php

namespace App\View\Components\Messages;

use Illuminate\View\Component;
use Illuminate\View\View;

class Status extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.messages.status');
    }
}
