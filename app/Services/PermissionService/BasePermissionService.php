<?php


namespace App\Services\PermissionService;


use App\Models\Menu;
use App\Services\Contracts\PermissionServiceContract;
use App\Services\MenuService\MenuService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

abstract class BasePermissionService implements PermissionServiceContract
{
    /**
     * Get permissions from config
     *
     * @return array
     */
    public function permissionsFromConfig(): array
    {
        return config('menus.default_permissions');
    }


    /**
     * Generate all menu permissions
     *
     * @return Permission[]|Collection
     */
    public function generateAllPermissions(): Collection
    {
        // get all created menu items
        $menus = (new MenuService())->createdMenuItems();

        $permission_service = new PermissionService();

        $default_permissions = $permission_service->permissionsFromConfig();

        $menus->each(function (Menu $menu) use ($default_permissions, $permission_service) {

            // default permissions
            $permissions = collect($default_permissions);

            // excepted permissions
            $excepted_permissions = $permission_service->exceptedMenuPermissions($menu->slug);

            // has excepted permissions
            if (count($excepted_permissions)) {
                $permissions = $permissions->filter(function ($description, $_permission) use ($excepted_permissions) {
                    return !in_array($_permission, $excepted_permissions);
                });
            }

            // additional permissions
            $additional_permissions = $permission_service->additionalMenuPermissions($menu->slug);
            // has additional permissions
            if (count($additional_permissions)) {
                $permissions = $permissions->merge($additional_permissions);
            }

            foreach ($permissions as $permissionName => $description) {
                // generate permission name
                $name = $this->generatedPermissionName($menu->slug, (string) $permissionName);
                // check permission exists or not
                $has_permission = $this->checkPermissionExists($name);

                if (!$has_permission) {
                    // create permission
                    $this->createSinglePermission($name, (string) $description);
                }
            }
        });

        return $this->permissions();
    }

    /**
     * Get all permissions
     *
     * @return Permission[]|Collection
     */
    public function permissions(): Collection
    {
        return Permission::all();
    }

    /**
     * Get permissions by ids
     *
     * @param array $ids
     * @return Permission[]|Collection
     */
    public function permissionsByIds(array $ids): Collection
    {
        return Permission::whereIn('id', $ids)->get();
    }

    /**
     * Menu excepted permissions
     *
     * @param string $menu_slug
     * @return array
     */
    public function exceptedMenuPermissions(string $menu_slug): array
    {
        return config('menus.available')[$menu_slug]['except_permissions'] ?? [];
    }

    /**
     * Menu additional permissions
     *
     * @param string $menu_slug
     * @return array
     */
    public function additionalMenuPermissions(string $menu_slug): array
    {
        return config('menus.available')[$menu_slug]['additional_permissions'] ?? [];
    }


    /**
     * Create single permission
     *
     * @param string $name Permission name
     * @param string $description Permission description
     * @return Permission Created permission
     */
    protected function createSinglePermission(string $name, string $description): Permission
    {
        return Permission::create([
            'name' => $name,
            'description' => $description
        ]);
    }

    /**
     * Generate permission name
     *
     * @param string $menuName Menu name
     * @param string $permissionName Permission name
     * @return string Generated permission name for menu
     */
    protected function generatedPermissionName(string $menuName, string $permissionName): string
    {
        return str_replace(' ', '_', strtolower($menuName)) . '-' . $permissionName;
    }


    /**
     * Check permission already exists or not
     *
     * @param string $permissionName Permission name
     * @return bool Permission exists or not status
     */
    protected function checkPermissionExists(string $permissionName): bool
    {
        return Permission::whereName($permissionName)->exists();
    }
}
