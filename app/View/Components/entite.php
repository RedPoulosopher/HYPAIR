<?php

namespace App\View\Components;

use Illuminate\View\Component;

class entite extends Component
{
    public $asso;
    public $destination;
    public $scoreVisible;

    public function __construct($asso, $destination, $scoreVisible = false)
    {
        $this->asso = $asso;
        $this->destination = $destination;
        $this->scoreVisible = $scoreVisible;
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
