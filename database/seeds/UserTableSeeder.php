<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'User')->first();
        $role_admin = Role::where('name', 'Admin')->first();

        $user1 = new User();
        $user1->name = 'User1';
        $user1->email = 'user1@user.com';
        $user1->password = bcrypt('123456');
        $user1->save();
        $user1->roles()->attach($role_user);

        $user2 = new User();
        $user2->name = 'User2';
        $user2->email = 'user2@user.com';
        $user2->password = bcrypt('123456');
        $user2->save();
        $user2->roles()->attach($role_user);

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('123456');
        $admin->save();
        $admin->roles()->attach($role_admin);

    }
}
