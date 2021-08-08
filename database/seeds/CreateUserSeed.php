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
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // User::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(User::class, 1)->create(["username"=>"admin01","role"=>"purchasing"]);

        factory(User::class, 10)->create();
    }
}
