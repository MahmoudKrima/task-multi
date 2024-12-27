<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermission = [
            'role.view',
            'role.create',
            'role.update',
        ];

        $permissions = [
            ...Admin::$permissions,
            ...User::$permissions,
            ...Setting::$permissions,
            ...$rolePermission,
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }
    }
}
