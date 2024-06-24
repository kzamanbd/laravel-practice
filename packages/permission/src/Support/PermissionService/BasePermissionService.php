<?php

namespace DraftScripts\Permission\Support\PermissionService;

use DraftScripts\Permission\Contracts\PermissionServiceContract;
use DraftScripts\Permission\Support\FeatureService\FeatureService;
use DraftScripts\Permission\Models\Feature;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

abstract class BasePermissionService implements PermissionServiceContract
{
    /**
     * Get permissions from config
     */
    public function permissionsFromConfig(): array
    {
        return config('lara-features.default_permissions');
    }

    /**
     * Generate all feature permissions
     *
     * @return Permission[]|Collection
     */
    public function generateAllPermissions(): Collection
    {
        // get all created feature items
        $features = (new FeatureService())->createdFeatureItems();

        $permission_service = new PermissionService();

        $default_permissions = $permission_service->permissionsFromConfig();

        $features->each(function (Feature $feature) use ($default_permissions, $permission_service) {

            // default permissions
            $permissions = collect($default_permissions);

            // excepted permissions
            $excepted_permissions = $permission_service->exceptedFeaturePermissions($feature->slug);

            // has excepted permissions
            if (count($excepted_permissions)) {
                $permissions = $permissions->filter(function ($description, $_permission) use ($excepted_permissions) {
                    return !in_array($_permission, $excepted_permissions);
                });
            }

            // additional permissions
            $additional_permissions = $permission_service->additionalFeaturePermissions($feature->slug);
            // has additional permissions
            if (count($additional_permissions)) {
                $permissions = $permissions->merge($additional_permissions);
            }

            foreach ($permissions as $permissionName => $description) {
                // generate permission name
                $name = $this->generatedPermissionName($feature->slug, (string) $permissionName);
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
     * @return Permission[]|Collection
     */
    public function permissionsByIds(array $ids): Collection
    {
        return Permission::whereIn('id', $ids)->get();
    }

    /**
     * Feature excepted permissions
     */
    public function exceptedFeaturePermissions(string $feature_slug): array
    {
        return config('lara-features.available')[$feature_slug]['except_permissions'] ?? [];
    }

    /**
     * Feature additional permissions
     */
    public function additionalFeaturePermissions(string $feature_slug): array
    {
        return config('lara-features.available')[$feature_slug]['additional_permissions'] ?? [];
    }

    /**
     * Create single permission
     *
     * @param  string  $name Permission name
     * @param  string  $description Permission description
     * @return Permission Created permission
     */
    protected function createSinglePermission(string $name, string $description): Permission
    {
        return Permission::create([
            'name' => $name,
            'description' => $description,
        ]);
    }

    /**
     * Generate permission name
     *
     * @param  string  $featureName Feature name
     * @param  string  $permissionName Permission name
     * @return string Generated permission name for feature
     */
    protected function generatedPermissionName(string $featureName, string $permissionName): string
    {
        return str_replace(' ', '_', strtolower($featureName)) . '-' . $permissionName;
    }

    /**
     * Check permission already exists or not
     *
     * @param  string  $permissionName Permission name
     * @return bool Permission exists or not status
     */
    protected function checkPermissionExists(string $permissionName): bool
    {
        return Permission::whereName($permissionName)->exists();
    }
}
