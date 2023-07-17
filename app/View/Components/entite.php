<?php

namespace App\View\Components;

use Illuminate\View\Component;

class entite extends Component
{
    public $asso;

    public function __construct($asso)
    {
        $this->asso = $asso;
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
