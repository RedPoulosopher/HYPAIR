<?php

namespace App\View\Components;

use Illuminate\View\Component;

class coming-event extends Component
{
    /** @var string */
    public $title;
    
    /** @var string */
    public $uid;

    /** @var string */
    public $slug;

    /** @var string */
    public $start;

    /** @var string */
    public $end;

    /** @var string */
    public $entite;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $start, $end, $entite, $uid, $slug)
    {
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->entite = $entite;
        $this->uid = $uid;
        $this->slug = $slug;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.coming-event');
    }
}
