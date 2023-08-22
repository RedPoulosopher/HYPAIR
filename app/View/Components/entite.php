<?php

namespace App\View\Components;

use Illuminate\View\Component;

class entite extends Component
{
    public $asso;
    public $destination;

    public function __construct($asso, $destination)
    {
        $this->asso = $asso;
        $this->destination = $destination;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.entite');
    }
}
