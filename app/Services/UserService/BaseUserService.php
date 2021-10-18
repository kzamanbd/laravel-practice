<?php


namespace App\Services\UserService;


use App\Models\User;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

abstract class BaseUserService implements UserServiceContract
{
    /**
     * All users
     *
     * @return User[]|Collection
     */
    public function allUsers(): Collection
    {
        return User::orderBy('name')->get();
    }

    /**
     * All users by paginate
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function allUsersByPaginate($perPage = 25): LengthAwarePaginator
    {
        return User::orderBy('name')->paginate($perPage);
    }

    /**
     * All trashed users
     *
     * @return Collection
     */
    public function allTrashedUsers(): Collection
    {
        return User::onlyTrashed()->orderBy('name')->get();
    }


    /**
     * Create a new user
     *
     * @param FormRequest $request
     * @return User
     */
    public function createNewUser(FormRequest $request): User
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $this->generatePassword($request->password),
            'email_verified_at' => now(),
        ];

        return User::create($data);
    }

    /**
     * Get user details by id
     *
     * @param int $id User id
     * @return User User model
     */
    public function userDetailsById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Get trashed user details by id
     *
     * @param int $id User id
     * @return User User model
     */
    public function trashedUserDetailsById(int $id): User
    {
        return User::onlyTrashed()->whereId($id)->first();
    }


    /**
     * Update a user by user id
     *
     * @param FormRequest $request
     * @param int $id User id
     * @return User Updated user details
     */
    public function updateUserById(FormRequest $request, int $id): User
    {
        // get user
        $user = $this->userDetailsById($id);

        // data
        $data = $request->only([
            'name',
            'email',
        ]);
        
        return tap($user)->update($data);
    }

    /**
     * Soft delete by user id
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function softDeleteById(int $id): bool
    {
        $user = User::findOrFail($id);

        return $this->softDeleteByUserInstance($user);
    }

    /**
     * Soft delete by user id
     *
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function softDeleteByUserInstance(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Soft delete by user id
     *
     * @param int $id
     * @return bool
     */
    public function forceDeleteById(int $id): bool
    {
        $user = User::withTrashed()->findOrFail($id);

        return $this->forceDeleteByUserInstance($user);
    }

    /**
     * Update user avatar by user id
     *
     * @param int $userId
     * @param UploadedFile $file
     * @return mixed
     */
    public function updateUserAvatarByUserId(int $userId, UploadedFile $file)
    {
        $user = (new UserService())->userDetailsById($userId);

        return $this->updateUserAvatarByUserInstance($user, $file);
    }

    /**
     * Update user avatar by user instance
     *
     * @param User $user
     * @param UploadedFile $file
     * @return mixed
     */
    public function updateUserAvatarByUserInstance(User $user, UploadedFile $file)
    {

    }


    /**
     * Soft delete by user id
     *
     * @param User $user
     * @return bool
     */
    public function forceDeleteByUserInstance(User $user): bool
    {
        return $user->forceDelete();
    }

    /**
     * Update user password by user id
     *
     * @param int $userId
     * @param string $newPassword
     * @return User
     */
    public function updatePasswordByUserId(int $userId, string $newPassword): User
    {
        return tap(User::findOrFail($userId))
            ->update([
                'password' => $this->generatePassword($newPassword)
            ]);
    }

    /**
     * Generate a new token
     *
     * @param User $user User instance
     * @return string New generated token
     */
    public function regenerateUserToken(User $user): string
    {
        $this->deleteUserTokens($user);

        return $user->createToken(request()->device_name ?? 'unknown')->plainTextToken;
    }

    /**
     * Delete user tokens
     *
     * @param User $user User instance
     * @return bool
     */
    public function deleteUserTokens(User $user): bool
    {
        return $user->tokens()->delete();
    }

    /**
     * User permissions by user id
     *
     * @param int $userId
     * @return Collection Permissions
     */
    public function userPermissionsByUserId(int $userId): Collection
    {
        $user = User::findOrFail($userId);
        return $this->userPermissionsByUserInstance($user);
    }

    /**
     * User permissions by user instance
     *
     * @param User $user User instance
     * @return Collection Permissions
     */
    public function userPermissionsByUserInstance(User $user): Collection
    {
        return $user->getAllPermissions();
    }

    /**
     * User roles by user instance
     *
     * @param User $user User instance
     * @return Collection roles
     */
    public function userRolesByUserInstance(User $user): Collection
    {
        return $user->roles;
    }

    /**
     * User roles by user id
     *
     * @param int $userId
     * @return Collection roles
     */
    public function userRolesByUserId(int $userId): Collection
    {
        $user = User::findOrFail($userId);
        return $this->userRolesByUserInstance($user);
    }

    /**
     * Restore user by id
     *
     * @param int $id User id
     * @return bool
     */
    public function restoreUserById(int $id): bool
    {
        $user = User::onlyTrashed()->whereId($id)->first();

        return $this->restoreUserByUserInstance($user);
    }

    /**
     * Restore user by user instance
     *
     * @param User $user
     * @return bool
     */
    public function restoreUserByUserInstance(User $user): bool
    {
        return $user->restore();
    }

    /**
     * Restore all trashed users
     *
     * @return bool restored user instance
     */
    public function restoreAllUsers(): bool
    {
        return User::onlyTrashed()->restore();
    }

    /**
     * Force delete all trashed users
     *
     * @return bool
     */
    public function deleteAllTrashed(): bool
    {
        return User::onlyTrashed()->forceDelete();
    }


    /**
     * Generate a unique username
     *
     * @return string
     */
    private function generateUsername(): string
    {
        return uniqid();
    }

    /**
     * Generate password
     *
     * @param $password
     * @return string
     */
    private function generatePassword($password): string
    {
        return Hash::make($password);
    }


}
