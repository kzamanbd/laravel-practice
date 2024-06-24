<?php

namespace Draftscripts\Permission\Livewire;

use Draftscripts\Permission\Support\UserService\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('lara-permission::components.app')]
class UserDetail extends Component
{
    public $user;
    public $features_permissions;

    public function mount(UserService $userService, int $id)
    {
        $this->user = $userService->userDetailsById($id);

        // get all permissions
        $permissions = $this->user->getAllPermissions();

        // manipulate feature permissions
        $this->features_permissions = $permissions->map(function (Permission $permission) {
            $permission['feature'] = (string) Str::of($permission->name)->before('-')->replace('_', ' ')->ucfirst();

            return $permission;
        })->groupBy('feature');
    }
    public function render(): View
    {
        return view('lara-permission::livewire.user-show');
    }
}
