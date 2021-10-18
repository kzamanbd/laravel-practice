<?php


namespace App\Services\Contracts;


use App\Models\User;
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
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function allUsersByPaginate($perPage = 25): LengthAwarePaginator;

    /**
     * All trashed users
     *
     * @return Collection
     */
    public function allTrashedUsers(): Collection;

    /**
     * Create a new user
     *
     * @param FormRequest $request
     * @return User
     */
    public function createNewUser(FormRequest $request): User;

    /**
     * Get user details by id
     *
     * @param int $id User id
     * @return User User model
     */
    public function userDetailsById(int $id): User;

    /**
     * Get trashed user details by id
     *
     * @param int $id User id
     * @return User User model
     */
    public function trashedUserDetailsById(int $id): User;

    /**
     * Update a user by user id
     *
     * @param FormRequest $request
     * @param int $id User id
     * @return User Updated user details
     */
    public function updateUserById(FormRequest $request, int $id): User;

    /**
     * Update user avatar by user id
     *
     * @param int $userId
     * @param UploadedFile $file
     * @return mixed
     */
    public function updateUserAvatarByUserId(int $userId, UploadedFile $file);

    /**
     * Update user avatar by user instance
     *
     * @param User $user
     * @param UploadedFile $file
     * @return mixed
     */
    public function updateUserAvatarByUserInstance(User $user, UploadedFile $file);

    /**
     * Restore user by id
     *
     * @param int $id User id
     * @return bool
     */
    public function restoreUserById(int $id): bool;

    /**
     * Restore user by user instance
     *
     * @param User $user
     * @return bool
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
     *
     * @param int $id
     * @return bool
     */
    public function softDeleteById(int $id): bool;

    /**
     * Soft delete by user id
     *
     * @param User $user
     * @return bool
     */
    public function softDeleteByUserInstance(User $user): bool;

    /**
     * Soft delete by user id
     *
     * @param int $id
     * @return bool
     */
    public function forceDeleteById(int $id): bool;

    /**
     * Force delete by user id
     *
     * @param User $user
     * @return bool
     */
    public function forceDeleteByUserInstance(User $user): bool;

    /**
     * Delete all trashed users
     *
     * @return bool
     */
    public function deleteAllTrashed(): bool;

    /**
     * Update user password by user id
     *
     * @param int $userId
     * @param string $newPassword
     * @return User
     */
    public function updatePasswordByUserId(int $userId, string $newPassword): User;

    /**
     * Delete user tokens
     *
     * @param User $user User instance
     * @return bool
     */
    public function deleteUserTokens(User $user): bool;

    /**
     * Generate a new token
     *
     * @param User $user User instance
     * @return string New generated token
     */
    public function regenerateUserToken(User $user): string;

    /**
     * User permissions by user id
     *
     * @param int $userId
     * @return Collection Permissions
     */
    public function userPermissionsByUserId(int $userId): Collection;

    /**
     * User permissions by user instance
     *
     * @param User $user User instance
     * @return Collection Permissions
     */
    public function userPermissionsByUserInstance(User $user): Collection;

    /**
     * User roles by user instance
     *
     * @param User $user User instance
     * @return Collection roles
     */
    public function userRolesByUserInstance(User $user): Collection;

    /**
     * User roles by user id
     *
     * @param int $userId
     * @return Collection roles
     */
    public function userRolesByUserId(int $userId): Collection;
}
