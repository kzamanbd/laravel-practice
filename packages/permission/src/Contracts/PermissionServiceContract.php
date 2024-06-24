<?php

namespace DraftScripts\Permission\Contracts;

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
     */
    public function permissionsFromConfig(): array;

    /**
     * Get permissions by ids
     *
     * @return Permission[]|Collection
     */
    public function permissionsByIds(array $ids): Collection;

    /**
     * Feature excepted permissions
     */
    public function exceptedFeaturePermissions(string $feature_slug): array;

    /**
     * Feature additional permissions
     */
    public function additionalFeaturePermissions(string $feature_slug): array;
}
