<?php

namespace App\Http\Controllers;

use App\Services\FeatureService\FeatureService;
use App\Services\PermissionService\PermissionService;
use App\Services\RoleService\RoleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class RoleController extends Controller
{
    protected string $permission_for = 'roles';

    /**
     * @throws PermissionForPropertyException
     */
    public function show($id, RoleService $roleService, FeatureService $featureService, PermissionService $permissionService): Application|Factory|View|\Illuminate\Foundation\Application
    {
        // check permission
        // $this->hasPermission('show');
        // get role details
        $role = $roleService->roleDetailsById($id);

        // get created features items
        $features = $featureService->createdFeatureItems();

        // get permissions
        $permissions = $permissionService->permissions();

        return view('role-show', compact('role', 'features', 'permissions'));
    }
}
