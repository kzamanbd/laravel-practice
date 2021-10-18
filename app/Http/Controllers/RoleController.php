<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Services\MenuService\MenuService;
use App\Services\PermissionService\PermissionService;
use App\Services\RoleService\RoleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    protected $permission_for = 'role';

    public $data = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws \App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function index(RoleService $service)
    {
        //
        $this->hasPermission('view');
        // get all roles
        $roles = $service->allRoles();

        return view('roles.index', compact( 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws \App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function create(MenuService $menuService, PermissionService $permissionService)
    {
        // check permission
        $this->hasPermission('create');
        // get created menus
        $menus = $menuService->createdMenuItems();
        // get permissions
        $permissions = $permissionService->permissions();

        return view('roles.create', compact('menus', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function store(RoleStoreRequest $request, RoleService $roleService)
    {
        // check permission
        $this->hasPermission('create');

        // create a new rule
        $role = $roleService->createRole($request);

        if (is_array($request->permissions)) {
            // sync permission role
            $roleService->syncPermissionsToRole($role, $request->permissions);
        }
        // return redirect to create form
        return redirect()->back()->withSuccess('Role created successfully');
    }


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

        return view('roles.show', compact('role', 'menus', 'permissions'));
    }


    /**
     * @param $id
     * @param RoleService $roleService
     * @param MenuService $menuService
     * @param PermissionService $permissionService
     * @return Application|Factory|View
     * @throws \App\Exceptions\PermissionForPropertyIsNotDeclaredInControllerException
     */
    public function edit($id, RoleService $roleService, MenuService $menuService, PermissionService $permissionService)
    {
        // check permission
        $this->hasPermission('update');

        // get role
        $role = $roleService->roleDetailsById($id);

        // get created menu items
        $menus = $menuService->createdMenuItems();

        // get permissions
        $permissions = $permissionService->permissions();

        return view('roles.edit', compact('role', 'menus', 'permissions'));
    }


    /**
     * @param RoleUpdateRequest $request
     * @param $id
     * @param RoleService $roleService
     * @return mixed
     */
    public function update(RoleUpdateRequest $request, $id, RoleService $roleService)
    {
        // check permission
        //$this->hasPermission('update');

        // get role by id
        $role = $roleService->updateRoleById($request, $id);

        // has permissions
        if (is_array($request->permissions)) {
            $roleService->syncPermissionsToRole($role, $request->permissions);
        }
        return redirect()->route('role.index')->withSuccess('Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id, RoleService $roleService)
    {
        $this->hasPermission('delete');
        if ($roleService->permanentlyDeleteRoleById($id)) {
            return redirect()->route('role.index')->withSuccess('Role deleted successfully');
        } else {
            return redirect()->route('role.index')->withSuccess('Failed to delete role', 'danger');
        }
    }
}
