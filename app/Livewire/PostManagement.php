<?php

namespace App\Livewire;

use Livewire\Component;

class PostManagement extends Component
{
    public $content;

    public function render()
    {
        return view('livewire.post-management');
    }
}
