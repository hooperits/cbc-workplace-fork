<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
    Role::create([
      'name' => 'ADMIN',
      'title' => 'Administradores',
      'is_active' => true,
      'is_admin' => true,
      'perm' => [],
    ]);
    Role::create([
      'name' => 'AFFILIATE',
      'title' => 'Afiliados',
      'is_active' => true,
      'is_admin' => true,
      'perm' => [],
    ]);
  }
}
