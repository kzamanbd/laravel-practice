<?php


namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

interface PermissionServiceContract
{
    /**
     * Generate all feature permissions
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
     * Feature excepted permissions
     *
     * @param string $feature_slug
     * @return array
     */
    public function exceptedFeaturePermissions(string $feature_slug): array;

    /**
     * Feature additional permissions
     *
     * @param string $feature_slug
     * @return array
     */
    public function additionalFeaturePermissions(string $feature_slug): array;
}
