<?php

namespace DraftScripts\Permission\Contracts;

use DraftScripts\Permission\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

interface UserServiceContract
{
    /**
     * All users
     *
     * @return User[]|Collection
     */
    public function allUsers(): Collection;

    /**
     * All users by paginate
     *
     * @param  int  $perPage
     */
    public function allUsersByPaginate($perPage = 25): LengthAwarePaginator;

    /**
     * All trashed users
     */
    public function allTrashedUsers(): Collection;

    /**
     * Create a new user
     */
    public function createNewUser(FormRequest $request): User;

    /**
     * Get user details by id
     *
     * @param  int  $id User id
     * @return User User model
     */
    public function userDetailsById(int $id): User;

    /**
     * Get trashed user details by id
     *
     * @param  int  $id User id
     * @return User User model
     */
    public function trashedUserDetailsById(int $id): User;

    /**
     * Update a user by user id
     *
     * @param  int  $id User id
     * @return User Updated user details
     */
    public function updateUserById(FormRequest $request, int $id): User;

    /**
     * Update user avatar by user id
     *
     * @return mixed
     */
    public function updateUserAvatarByUserId(int $userId, UploadedFile $file);

    /**
     * Update user avatar by user instance
     *
     * @return mixed
     */
    public function updateUserAvatarByUserInstance(User $user, UploadedFile $file);

    /**
     * Restore user by id
     *
     * @param  int  $id User id
     */
    public function restoreUserById(int $id): bool;

    /**
     * Restore user by user instance
     */
    public function restoreUserByUserInstance(User $user): bool;

    /**
     * Restore all trashed users
     *
     * @return bool restored user instance
     */
    public function restoreAllUsers(): bool;

    /**
     * Soft delete by user id
     */
    public function softDeleteById(int $id): bool;

    /**
     * Soft delete by user id
     */
    public function softDeleteByUserInstance(User $user): bool;

    /**
     * Soft delete by user id
     */
    public function forceDeleteById(int $id): bool;

    /**
     * Force delete by user id
     */
    public function forceDeleteByUserInstance(User $user): bool;

    /**
     * Delete all trashed users
     */
    public function deleteAllTrashed(): bool;

    /**
     * Update user password by user id
     */
    public function updatePasswordByUserId(int $userId, string $newPassword): User;

    /**
     * Delete user tokens
     *
     * @param  User  $user User instance
     */
    public function deleteUserTokens(User $user): bool;

    /**
     * Generate a new token
     *
     * @param  User  $user User instance
     * @return string New generated token
     */
    public function regenerateUserToken(User $user): string;

    /**
     * User permissions by user id
     *
     * @return Collection Permissions
     */
    public function userPermissionsByUserId(int $userId): Collection;

    /**
     * User permissions by user instance
     *
     * @param  User  $user User instance
     * @return Collection Permissions
     */
    public function userPermissionsByUserInstance(User $user): Collection;

    /**
     * User roles by user instance
     *
     * @param  User  $user User instance
     * @return Collection roles
     */
    public function userRolesByUserInstance(User $user): Collection;

    /**
     * User roles by user id
     *
     * @return Collection roles
     */
    public function userRolesByUserId(int $userId): Collection;
}
