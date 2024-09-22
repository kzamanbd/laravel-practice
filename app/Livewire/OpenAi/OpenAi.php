<?php

namespace App\Livewire\OpenAi;

use Livewire\Component;

class OpenAi extends Component
{

    public $customData = false;

    public function mount()
    {
        $this->customData = request('action') == 'custom';
    }

    public function render()
    {
        return view('livewire.open-ai.open-ai');
    }
}
