<?php

namespace App\Livewire\OpenAi;

use Livewire\Component;

class OwnMessage extends Component
{
    public array $message;

    public function render()
    {
        return view('livewire.open-ai.own-message');
    }
}
