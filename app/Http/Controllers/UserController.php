<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use App\Services\UserService\UserService;
use Spatie\Permission\Models\Permission;
use App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException;

class UserController extends Controller
{
    protected string $permission_for = 'user';

    /**
     * @param $id
     * @param UserService $userService
     * @return View
     * @throws PermissionForPropertyIsNotDeclaredInControllerException
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
            $permission['feature'] = (string)Str::of($permission->name)->before('-')->replace('_', ' ')->ucfirst();
            return $permission;
        })->groupBy('feature');

        return view('user-show', compact('user', 'features_permissions'));
    }
}
