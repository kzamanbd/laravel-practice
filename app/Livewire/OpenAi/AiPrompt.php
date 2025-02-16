<?php

namespace App\Livewire\OpenAi;

use Livewire\Component;
use Livewire\Attributes\Validate;

class AiPrompt extends Component
{
    #[Validate('required|string|max:1000')]
    public string $body = '';

    public array $messages = [];

    public function mount()
    {
        $this->messages[] = [
            'role' => 'system',
            'content' => 'You are a helpful assistant. The response will markdown format (if needed) with well-organized, detailed, formatted and clean content.'
        ];
    }

    public function submit()
    {
        $this->validate();

        $this->messages[] = ['role' => 'user', 'content' => $this->body];
        $this->messages[] = ['role' => 'assistant', 'content' => ''];

        $this->body = '';
    }

    public function render()
    {
        return view('livewire.open-ai.ai-prompt');
    }
}