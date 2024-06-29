<?php

namespace App\Livewire;

use Livewire\Component;

class TipTapEditor extends Component
{

    public $content;

    public function mount($content = null)
    {
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.layout.tip-tap-editor');
    }
}
