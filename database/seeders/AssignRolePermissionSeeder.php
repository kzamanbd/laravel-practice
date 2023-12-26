<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // permissions
        $permissions = Permission::all()->pluck('id');
        // admin roles
        $adminRole = Role::whereName('Admin')->first();
        // give all permission to admin
        $adminRole->givePermissionTo($permissions);
        // first user
        $user = User::first();
        // set admin role to first user
        $user->assignRole($adminRole->id);
    }
}
