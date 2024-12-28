<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant1 = Tenant::create(['id' => 'main']);
        $tenant1->domains()->create(['domain' => 'main.localhost']);
        $tenant2 = Tenant::create(['id' => 'sub']);
        $tenant2->domains()->create(['domain' => 'sub.localhost']);
    }
}
