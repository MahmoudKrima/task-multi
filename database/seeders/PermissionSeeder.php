<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Setting;
use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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
        $activityPermission=[
            'activity_log.view',
        ];

        $permissions = [
            ...Admin::$permissions,
            ...Setting::$permissions,
            ...Task::$permissions,
            ...TaskAttachment::$permissions,
            ...$rolePermission,
            ...$activityPermission,
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }
    }
}
