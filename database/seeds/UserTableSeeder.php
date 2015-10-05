<?php

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
        DB::table('users')->insert([
            'name' => env('ROOT_USERNAME'),
            'email' => env('ROOT_EMAIL'),
            'password' => bcrypt(env('ROOT_PASSWORD')),
            'is_admin' => true,
        ]);
    }
}
