<?php

namespace DraftScripts\Permission\Contracts;


use DraftScripts\Permission\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

interface RoleServiceContract
{
    /**
     * All roles
     *
     * @return Role[]|Collection
     */
    public function allRoles(): Collection;

    /**
     * Create a new role
     */
    public function createRole(FormRequest $request): Role;

    /**
     * Role by id
     */
    public function roleDetailsById(int $id): Role;

    /**
     * Update role by id
     */
    public function updateRoleById(FormRequest $request, int $id): Role;

    /**
     * Update role by role instance
     */
    public function updateRoleByRoleInstance(FormRequest $request, Role $role): Role;

    /**
     * Permanently delete role by id
     */
    public function permanentlyDeleteRoleById(int $id): bool;

    /**
     * Sync permissions to role
     */
    public function syncPermissionsToRole(Role $role, array $permissions): Role;

    /**
     * Sync role to user by user instance
     */
    public function syncRoleToUserByUserInstance(User $user, array $roles): User;

    /**
     * Sync role to user by user id
     */
    public function syncRoleToUserByUserId(int $id, array $roles): User;
}
