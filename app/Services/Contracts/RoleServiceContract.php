<?php


namespace App\Services\Contracts;


use App\Models\User;
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
     *
     * @param FormRequest $request
     * @return Role
     */
    public function createRole(FormRequest $request): Role;

    /**
     * Role by id
     *
     * @param int $id
     * @return Role
     */
    public function roleDetailsById(int $id): Role;

    /**
     * Update role by id
     *
     * @param FormRequest $request
     * @param int $id
     * @return Role
     */
    public function updateRoleById(FormRequest $request, int $id): Role;

    /**
     * Update role by role instance
     *
     * @param FormRequest $request
     * @param Role $role
     * @return Role
     */
    public function updateRoleByRoleInstance(FormRequest $request, Role $role): Role;

    /**
     * Permanently delete role by id
     *
     * @param int $id
     * @return bool
     */
    public function permanentlyDeleteRoleById(int $id): bool;

    /**
     * Sync permissions to role
     *
     * @param Role $role
     * @param array $permissions
     * @return Role
     */
    public function syncPermissionsToRole(Role $role, array $permissions): Role;

    /**
     * Sync role to user by user instance
     *
     * @param User $user
     * @param array $roles
     * @return User
     */
    public function syncRoleToUserByUserInstance(User $user, array $roles): User;

    /**
     * Sync role to user by user id
     *
     * @param int $id
     * @param array $roles
     * @return User
     */
    public function syncRoleToUserByUserId(int $id, array $roles): User;
}
