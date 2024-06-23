<?php

namespace App\Http\Controllers;

trait PermissionForPropertyValidation
{
    /**
     * Has permission for access controller method
     *
     * @throws PermissionForPropertyException
     */
    protected function hasPermission(string $permissionType): void
    {
        // get permission name
        $permission_name = $this->getPermissionName($permissionType);

        abort_if(!auth()->user()->can($permission_name), 401);
    }

    /**
     * Get Permission name
     *
     * @throws PermissionForPropertyException
     */
    protected function getPermissionName(string $permissionType): string
    {
        if (!property_exists($this, 'permission_for')) {
            throw new PermissionForPropertyException($this->generateErrorMessage());
        }

        return str_contains($permissionType, '-')
            ?
            $this->permission_for . '_' . $permissionType
            :
            $this->permission_for . '-' . $permissionType;
    }

    /**
     * Generate property not found message
     */
    private function generateErrorMessage(): string
    {
        return 'permission_for property is not declared on' . get_class($this);
    }
}
