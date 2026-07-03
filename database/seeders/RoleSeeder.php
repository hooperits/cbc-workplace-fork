<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminRole();
    }

    protected function createAdminRole()
    {
        // Use firstOrCreate to make the seeder idempotent (safe to run multiple times)
        Role::firstOrCreate(
            ['name' => 'ADMIN'],
            [
                'title'     => 'ADMIN',
                'is_active' => true,
                'is_admin'  => true,
                'perm'      => [],
            ]
        );

        Role::firstOrCreate(
            ['name' => 'DEACONO'],
            [
                'title'     => 'DEACONO',
                'is_active' => true,
                'is_admin'  => false,
                'perm'      => [],
            ]
        );

        Role::firstOrCreate(
            ['name' => 'AFFILIADO'],
            [
                'title'     => 'AFFILIADO',
                'is_active' => true,
                'is_admin'  => false,
                'perm'      => [],
            ]
        );
    }
}
