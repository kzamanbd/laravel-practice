<?php

namespace DraftScripts\Permission\Support\RoleService;


use DraftScripts\Permission\Contracts\RoleServiceContract;
use DraftScripts\Permission\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

abstract class BaseRoleService implements RoleServiceContract
{
    /**
     * All roles
     *
     * @return Role[]|Collection
     */
    public function allRoles(): Collection
    {
        return Role::all();
    }

    /**
     * Create a new role
     */
    public function createRole(FormRequest $request): Role
    {
        return Role::create($request->only('name', 'description'));
    }

    /**
     * Role by id
     */
    public function roleDetailsById(int $id): Role
    {
        return Role::with('permissions')->findOrFail($id);
    }

    /**
     * Update role by id
     */
    public function updateRoleById(FormRequest $request, int $id): Role
    {
        $role = Role::findOrFail($id);

        return $this->updateRoleByRoleInstance($request, $role);
    }

    /**
     * Update role by role instance
     */
    public function updateRoleByRoleInstance(FormRequest $request, Role $role): Role
    {
        return tap($role)->update($request->only('name', 'description'));
    }

    /**
     * Permanently delete role by id
     *
     * @throws \Exception
     */
    public function permanentlyDeleteRoleById(int $id): bool
    {
        return Role::findOrFail($id)->delete();
    }

    /**
     * Sync permissions to role
     */
    public function syncPermissionsToRole(Role $role, array $permissions): Role
    {
        return $role->syncPermissions($permissions);
    }

    /**
     * Sync roles to user by user instance
     */
    public function syncRoleToUserByUserInstance(User $user, array $roles): User
    {
        // assign role
        return $user->syncRoles($roles);
    }

    /**
     * Sync roles to user by user id
     *
     * @param  int  $id User id
     * @param  array  $roles Roles
     */
    public function syncRoleToUserByUserId(int $id, array $roles): User
    {
        $user = User::findOrFail($id);

        return $this->syncRoleToUserByUserInstance($user, $roles);
    }
}
