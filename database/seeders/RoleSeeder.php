<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all(); // Global permissions
        $tenants = Tenant::all(); // Fetch all tenants

        foreach ($tenants as $tenant) {
            if (!Role::where(['name' => 'admin', 'tenant_id' => $tenant->id])->exists()) {
                $adminRole = Role::create([
                    'name' => 'admin',
                    'guard_name' => 'admin',
                    'tenant_id' => $tenant->id,
                ]);
                $adminRole->syncPermissions($permissions);
            }

            Role::create([
                'name' => 'manager',
                'guard_name' => 'admin',
                'tenant_id' => $tenant->id,
            ]);

            Role::create([
                'name' => 'employee',
                'guard_name' => 'admin',
                'tenant_id' => $tenant->id,
            ]);
        }
    }
}
