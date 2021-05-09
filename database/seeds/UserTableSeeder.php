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
        factory(App\User::class, 20)->create()->each(function ($user) {
            $user->save();
            $roles = Role::inRandomOrder()->take(1)->get();
            $user->roles()->saveMany($roles);
        });
        
        $role_of_admin = Role::where("name", "admin")->first();
        $role_of_author = Role::where("name", "author")->first();
        $role_of_user = Role::where("name", "user")->first();

        $user = new User();
        $user->name = "Omar Essaouaf";
        $user->email = "omar@gmail.com";
        $user->phone = "0634543523";
        $user->address = "Dar Elmiloudi Street";
        $user->country = "Morroco";
        $user->state = "Grand casablanca";
        $user->city = "Casablanca";
        $user->zip = 2332323;
        $user->bio = "Hi i am Omar Essaouaf and I am An Admin";
        $user->password = Hash::make("password");
        $user->avatar = "/storage/images/users/noavataruser.jpg";
        $user->save();
        $user->roles()->attach($role_of_admin);


        $user = new User();
        $user->name = "Salah Weld Bidawiya";
        $user->email = "salah@gmail.com";
        $user->phone = "0634543523";
        $user->address = "Boutwil Street";
        $user->country = "Morroco";
        $user->state = "Grand casablanca";
        $user->city = "Casablanca";
        $user->zip = 2332323;
        $user->bio = "Hi i am Salah Weld Bidawiya and I am An Author";
        $user->password = Hash::make("password");
        $user->avatar = "/storage/images/users/noavataruser.jpg";
        $user->save();
        $user->roles()->attach($role_of_author);

        $user = new User();
        $user->name = "Hamid Lakrouni";
        $user->email = "hamid@gmail.com";
        $user->phone = "0634543523";
        $user->address = "English Street";
        $user->country = "Morroco";
        $user->state = "Grand casablanca";
        $user->city = "Casablanca";
        $user->zip = 2332323;
        $user->bio = "Hi i am Hamid Lakrouni and I am A User";
        $user->password = Hash::make("password");
        $user->avatar = "/storage/images/users/noavataruser.jpg";
        $user->save();
        $user->roles()->attach($role_of_user);
    }
}
