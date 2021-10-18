<?php

namespace App\Http\Controllers;

use App\Services\PermissionService\PermissionService;

class PermissionController extends Controller
{

    /**
     * Generate all permissions
     *
     * @param PermissionService $permissionService
     * @return mixed
     */
    public function generateAllPermissions(PermissionService $permissionService)
    {
        $permissionService->generateAllPermissions();
        return redirect()->back()->withSuccess('All permissions generated');
    }
}
