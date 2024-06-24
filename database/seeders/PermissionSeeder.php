<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private $permissions = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

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
        return str_replace(' ', '_', strtolower($featureName)).'-'.$permissionName;
    }
}
