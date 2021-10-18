<?php


namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

interface PermissionServiceContract
{
    /**
     * Generate all menu permissions
     *
     * @return Permission[]|Collection
     */
    public function generateAllPermissions(): Collection;

    /**
     * Get all permissions
     *
     * @return Permission[]|Collection
     */
    public function permissions(): Collection;

    /**
     * Get permissions from config
     *
     * @return array
     */
    public function permissionsFromConfig(): array;

    /**
     * Get permissions by ids
     *
     * @param array $ids
     * @return Permission[]|Collection
     */
    public function permissionsByIds(array $ids): Collection;

    /**
     * Menu excepted permissions
     *
     * @param string $menu_slug
     * @return array
     */
    public function exceptedMenuPermissions(string $menu_slug): array;

    /**
     * Menu additional permissions
     *
     * @param string $menu_slug
     * @return array
     */
    public function additionalMenuPermissions(string $menu_slug): array;
}
