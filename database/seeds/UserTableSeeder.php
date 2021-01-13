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
        $roleUser = Role::findByName('user', 'api');
        $roleAdmin = Role::findByName('admin', 'api');
        $roleSuperAdmin = Role::findByName('superadmin', 'api');

        factory(User::class)->create(['email' => 'superadmin@admin.io'])->assignRole($roleSuperAdmin);
        factory(User::class)->create(['email' => 'admin@admin.io'])->assignRole($roleAdmin);
        factory(User::class, rand(10, 50))->create()->each(function ($user) use ($roleUser) {
            $user->assignRole($roleUser);
        });
    }
}
