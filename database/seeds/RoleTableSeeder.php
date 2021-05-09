<?php

use Illuminate\Database\Seeder;
use App\User;
use App\role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_of_admin = new Role();
        $role_of_admin->name ="admin";
        $role_of_admin->description="this is an admin role";
        $role_of_admin->save();

        $role_of_author = new Role();
        $role_of_author->name ="author";
        $role_of_author->description="this is an author role";
        $role_of_author->save();

        $role_of_user = new Role();
        $role_of_user->name ="user";
        $role_of_user->description="this is a user role";
        $role_of_user->save();
        


        
    }
}
