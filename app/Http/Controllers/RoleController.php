<?php

namespace App\Http\Controllers;

use App\Services\MenuService\MenuService;
use App\Services\PermissionService\PermissionService;
use App\Services\RoleService\RoleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{

    protected $permission_for = 'role';

    /**
     * @param $id
     * @param RoleService $roleService
     * @param MenuService $menuService
     * @param PermissionService $permissionService
     * @return Application|Factory|View
     * @throws \App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function show($id, RoleService $roleService, MenuService $menuService, PermissionService $permissionService)
    {
        // check permission
        $this->hasPermission('show');
        // get role details
        $role = $roleService->roleDetailsById($id);

        // get created menu items
        $menus = $menuService->createdMenuItems();

        // get permissions
        $permissions = $permissionService->permissions();

        return view('role-show', compact('role', 'menus', 'permissions'));
    }
}
