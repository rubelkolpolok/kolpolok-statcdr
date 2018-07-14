<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $role_super_admin = new Role();
        $role_super_admin->name = "superadmin";
        $role_super_admin->description = "Most High level User, Manage StatCDR Customer BAse";
        $role_super_admin->save();

        $role_admin = new Role();
        $role_admin->name = "admin";
        $role_admin->description = "They are running the StatCDR Software";
        $role_admin->save();

        $role_admin_user = new Role();
        $role_admin_user->name = "user";
        $role_admin_user->description = "They are the Admin User.";
        $role_admin_user->save();
    }
}
