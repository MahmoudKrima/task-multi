<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '0123456789',
            'password' => '123456789',
            'image' => 'defaults/admin.jpg',
            'status' => 'active',
        ]);
        $admin->assignRole('administrator');
    }
}
