<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Services\PermissionService\PermissionService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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
        (new PermissionService())->generateAllPermissions();

//        $menus = Menu::all();
//
//        foreach($menus as $menu){
//            foreach (config('menus.default_permissions') as $permissionName => $description) {
//                generate permission name
//                $name = $this->generatedPermissionName($menu->name, $permissionName);
//
//                $permission = [
//                    'name' => $name,
//                    'description' => $description,
//                    'guard_name' => 'web',
//                    'created_at' => now(),
//                    'updated_at' => now()
//                ];
//                array_push($this->permissions, $permission);
//            }
//        };
//        Permission::insert($this->permissions);
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
}
