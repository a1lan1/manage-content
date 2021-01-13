<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleUser = Role::findByName(Role::ROLE_USER, 'api');
        $roleAdmin = Role::findByName(Role::ROLE_ADMIN, 'api');
        $roleSuperAdmin = Role::findByName(Role::ROLE_SUPERADMIN, 'api');

        factory(User::class)->create(['email' => 'superadmin@admin.io'])->assignRole($roleSuperAdmin);
        factory(User::class)->create(['email' => 'admin@admin.io'])->assignRole($roleAdmin);
        factory(User::class, rand(10, 50))->create()->each(function ($user) use ($roleUser) {
            $user->assignRole($roleUser);
        });
    }
}
