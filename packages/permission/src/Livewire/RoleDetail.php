<?php

namespace DraftScripts\Permission\Livewire;

use DraftScripts\Permission\Support\FeatureService\FeatureService;
use DraftScripts\Permission\Support\PermissionService\PermissionService;
use DraftScripts\Permission\Support\RoleService\RoleService;
use Illuminate\Contracts\View\View;


class RoleDetail extends PermissionLayout
{
    public $role;
    public $features = [];
    public $permissions = [];

    public function mount(RoleService $roleService, FeatureService $featureService, PermissionService $permissionService, int $id): void
    {
        try {
            $this->role = $roleService->roleDetailsById($id);

            // get created features items
            $this->features = $featureService->createdFeatureItems();

            // get permissions
            $this->permissions = $permissionService->permissions();
        } catch (\Exception $exception) {

            $this->dispatch('error', $exception->getMessage());
        }
    }

    public function render(): View
    {
        return view('lara-permission::livewire.role-detail');
    }
}
