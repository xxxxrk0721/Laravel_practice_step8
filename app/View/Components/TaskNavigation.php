<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TaskNavigation extends Component
{
    public $isAdmin;
    /**
     * Create a new component instance.
     */
    public function __construct($isAdmin = false)
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.task-navigation');
    }
}
