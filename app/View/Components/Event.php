<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Event extends Component
{
    // Données à récupérer du serveur

    public $index;
    public $title;
    public $author;
    //public $tags;
    //public $date;
    //public $description;

    // Il faut aussi récupérer l'icone du post
    // public $image;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($index, $title, $author)
    {
        $this->title = $title;
        $this->author = $author;
        $this->index = $index;
        /*
        $this->tags = $tags;
        $this->date = $date;
        $this->description = $description;
        */
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.event');
    }
}
