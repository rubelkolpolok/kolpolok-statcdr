<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_super_admin = Role::where("name", "superadmin")->first();
        $role_admin       = Role::where("name", "admin")->first();

        $super_admin = new User();
        $super_admin->name = "Mr. Super Admin";
        $super_admin->email = "superadmin@mail.com";
        $super_admin->password = Hash::make("superadmin");
        $super_admin->save();
        $super_admin->roles()->attach($role_super_admin);

        $admin = new User();
        $admin->name = "Mr. Admin";
        $admin->email = "admin@mail.com";
        $admin->password = Hash::make("admin");
        $admin->save();
        $admin->roles()->attach($role_admin, ['userPlan' => 3]);
    }
}
