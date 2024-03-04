<?php

namespace App\Http\Controllers;

use App\Services\UserService\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    protected string $permission_for = 'users';

    /**
     * @return View
     *
     * @throws PermissionForPropertyException
     */
    public function show($id, UserService $userService)
    {
        // check permission
        $this->hasPermission('show');
        //get user
        $user = $userService->userDetailsById($id);

        // get all permissions
        $permissions = $user->getAllPermissions();

        // manipulate feature permissions
        $features_permissions = $permissions->map(function (Permission $permission) {
            $permission['feature'] = (string) Str::of($permission->name)->before('-')->replace('_', ' ')->ucfirst();

            return $permission;
        })->groupBy('feature');

        return view('user-show', compact('user', 'features_permissions'));
    }
}
