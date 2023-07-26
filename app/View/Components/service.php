<?php

namespace App\View\Components;

use Illuminate\View\Component;

class service extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $nom;
    public $destination;
    public $logo;
    public $color;
    
    public function __construct($nom, $destination, $color, $logo)
    {
        $this->nom = $nom;
        $this->destination = $destination;
        $this->logo = $logo;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.service');
    }
}
