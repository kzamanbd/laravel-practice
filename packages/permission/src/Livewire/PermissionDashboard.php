<?php

namespace DraftScripts\Permission\Livewire;

use DraftScripts\Permission\Models\Feature;
use DraftScripts\Permission\Support\PermissionService\PermissionService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionDashboard extends PermissionLayout
{
    /**
     * @return void
     */
    public function syncPermission(PermissionService $permissionService): void
    {
        try {
            $permissionService->generateAllPermissions();
            $this->dispatch('success', 'Permissions synced successfully.');
        } catch (\Exception $e) {
            $this->dispatch('error', $e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function syncFeature(): void
    {
        if (Feature::all()->count() > 0) {
            $this->dispatch('warning', 'Features already synced');
            return;
        }

        try {
            $features = File::json(__DIR__ . '/../../database/features.json');
            // add timestamps
            $features = collect($features['data'])->map(function ($feature) {
                $feature['created_at'] = now();
                $feature['updated_at'] = now();
                $feature['slug'] = $feature['slug'] ?? Str::slug($feature['name']);
                return $feature;
            })->toArray();

            // insert into database
            Feature::insert($features);

            $this->dispatch('success', 'Features successfully synced');
        } catch (\Exception $exception) {
            $this->dispatch('error', $exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function syncRole(): void
    {
        if (Role::all()->count() > 0) {
            $this->dispatch('warning', 'Role already synced');
            return;
        }

        try {
            $rolesInitial = ['Admin', 'User', 'Editor'];
            $roles = [];
            foreach ($rolesInitial as $role) {
                $r = [
                    'name' => $role,
                    'description' => 'Dummy description',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $roles[] = $r;
            }

            Role::insert($roles);

            $this->dispatch('success', 'Role successfully synced');
        } catch (\Exception $exception) {
            $this->dispatch('error', $exception->getMessage());
        }
    }

    /**
     * @return void
     */
    public function assignPermission(): void
    {
        try {
            // permissions
            $permissions = Permission::all()->pluck('id');
            // admin roles
            $adminRole = Role::whereName('Admin')->first();
            // give all permission to admin
            $adminRole->givePermissionTo($permissions);
            // first user
            $model = config('lara-permission.model');
            $user = (new $model)::first();
            // set admin role to first user
            $user->assignRole($adminRole->id);

            $this->dispatch('success', 'Assigned permissions successfully,' . $user->name);
        } catch (\Exception $exception) {
            $this->dispatch('error', $exception->getMessage());
        }
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('lara-permission::livewire.permission');
    }
}
