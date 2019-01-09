<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->user_name = "admin";
        $user->email = "admin@mail.com";
        $user->phone = "0000000";
        $user->license = "100";
        $user->startup = "100";
        $user->last_connection = "";
        $user->role = "Admin";
        $user->note = "I am super admin";
        $user->password = bcrypt("admin");
        $user->origin_password = "admin";
        $user->parent_id = 0;
        $user->user_real_name ="georgy";
        $user->save();
    }
}
