<?php

namespace DraftScripts\Permission\Livewire;

use DraftScripts\Permission\Support\UserService\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;


class UserDetail extends PermissionLayout
{
    public $user;
    public $features_permissions = [];

    public function mount(UserService $userService, int $id)
    {
        $this->user = $userService->userDetailsById($id);

        try {
            // get all permissions
            $permissions = $this->user->getAllPermissions();

            // manipulate feature permissions
            $this->features_permissions = $permissions->map(function (Permission $permission) {
                $permission['feature'] = (string)Str::of($permission->name)->before('-')->replace('_', ' ')->ucfirst();

                return $permission;
            })->groupBy('feature');
        } catch (\Exception $exception) {

            $this->dispatch('error', $exception->getMessage());
        }
    }

    public function render(): View
    {
        return view('lara-permission::livewire.user-show');
    }
}
