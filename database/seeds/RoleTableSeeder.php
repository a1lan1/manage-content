<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => Role::ROLE_USER]);
        Role::create(['name' => Role::ROLE_ADMIN]);
        Role::create(['name' => Role::ROLE_SUPERADMIN]);
    }
}
