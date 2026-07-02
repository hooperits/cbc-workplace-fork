<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public $tableName = 'users';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdminUser();
    }

    protected function createAdminUser()
    {
        $role = Role::query()->where('name', 'ADMIN')->first();

        // Use updateOrCreate (or firstOrCreate) so the seeder is safe to run repeatedly
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'role_id'       => $role->id,
                'name'          => 'Admin',
                'email'         => 'admin@gmail.com',
                'password'      => 'password',
                'can_sponsor'   => true,
                'is_active'     => true,
                'is_blocked'    => false,
            ]
        );

        User::updateOrCreate(
            ['username' => 'justin'],
            [
                'role_id'       => $role->id,
                'name'          => 'Justin Kurmaty',
                'email'         => 'justin.whoami@gmail.com',
                'password'      => 'password',
                'can_sponsor'   => true,
                'is_active'     => true,
                'is_blocked'    => false,
            ]
        );
    }
}
