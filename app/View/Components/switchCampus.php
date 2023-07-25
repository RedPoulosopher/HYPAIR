<?php

namespace App\View\Components;

use Illuminate\View\Component;

class switchCampus extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $campus;
    public function __construct($campus)
    {
        $this->campus = $campus;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.switch-campus');
    }
}
