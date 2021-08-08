<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;

class CreateUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Admin",
            "username"=> "admin",
            "email"=> "admin@test.com",
            "password"=> bcrypt("password"),
            "role"=> "purchasing",
        ]);
        //factory(User::class, 1)->create(["username"=>"admin01","role"=>"purchasing"]);

        //factory(User::class, 10)->create();
    }
}
