<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class RoleList extends Component
{
    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.role-list')->layoutData([
            'title' => 'Role List',
        ]);
    }
}
