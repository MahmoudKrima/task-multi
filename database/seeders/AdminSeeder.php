<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant=Tenant::first();
        $admin = Admin::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '0123456789',
            'password' => '123456789',
            'image' => 'defaults/admin.jpg',
            'status' => 'active',
            'tenant_id'=>$tenant->id,
        ]);
        $role = Role::where('name', 'admin')
        ->where('tenant_id', $tenant->id)
        ->where('guard_name', 'admin')
        ->first();
        $admin->assignRole($role);
    }
}
