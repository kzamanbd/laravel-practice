<?php

namespace App\Livewire;

use Livewire\Component;

class Blogging extends Component
{
    public $content = '<p>Hello world! :-)</p>';

    public function postAction(): void
    {
        dd($this->content);
    }

    public function render()
    {
        return view('livewire.blogging');
    }
}
