<?php

namespace DraftScripts\Permission\Livewire;

use App\Livewire\Actions\Logout;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Navigation extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function render(): View
    {
        return view('lara-permission::livewire.layout.navigation');
    }
}
