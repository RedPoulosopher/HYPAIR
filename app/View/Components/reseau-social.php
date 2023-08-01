<?php

namespace App\View\Components;

use Illuminate\View\Component;

class reseau-social extends Component
{
    public $reseau;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($reseau)
    {
        $this->$reseau = $reseau;        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reseau-social');
    }
}
